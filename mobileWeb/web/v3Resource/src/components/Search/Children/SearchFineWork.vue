<template>
  <div class="wrapper">
    <div class="searchBox clearfix" ref="searchBox">
      <form action="" enctype='application/json' @submit.prevent="searchKeyWord">
        <input class="searchAll" ref="searchAll" type="search" name="word" autocomplete="false" autocorrect="false" v-model="msg" placeholder="搜索精品作业"/>
      </form>
      <div class="serachBtnBox clearfix">
        <div class="cleanBtn fl" @click="clean" v-show="msg.length > 0">
          <img src="../../../images/clean.png">
        </div>
        <div class="searchLine fl" v-show="msg.length > 0">
          <img src="../../../images/searchLine.png">
        </div>
        <div class="searchBtn fr" @click="searchKeyWord" v-show="msg.length > 0">
          <img src="../../../images/search.png">
        </div>
        <div class="searchBtn fr" v-show="msg.length == 0">
          <img src="../../../images/noSearch.png">
        </div>
      </div>
      <div class="canleBtn" @click="goHome">取消</div>
    </div>

    <div class="searchContent" ref="searchContent" v-show="homeworkLists.length > 0">
      <mt-loadmore :bottom-method="loadBottom" :bottom-all-loaded="allLoaded" ref="loadmore" @bottom-status-change="handleBottomChange" :auto-fill="isAutoFill">
        <ul class="fineWorkList">
          <li class="fineWorkCtn" v-for="lists in homeworkLists" v-tap="{methods: toHomework, listId: lists.id}">
            <div class="titleImg" :class="{base: lists.homeworkType == 2241110, advance: lists.homeworkType == 2241111, check: lists.homeworkType == 2241100}"></div>
            <p v-html="lists.name"></p>
          </li>
        </ul>
      </mt-loadmore>
    </div>
    <noList v-show="homeworkLists.length == 0" :info="info"></noList>
  </div>
</template>

<script>
  import noList from '../../Global/NoList/NoList.vue'
  import Bus from '../../Global/Bus/bus.js'
  import { Toast } from 'mint-ui'
  export default {
    data() {
      return {
        msg: '',
        keyword: '',
        info: '',
        pageIndex: 2, // 页码
        pageCount: 0, // 总页数
        allLoaded: false, // 允许再次调用上拉函数
        isAutoFill: false, // 是否自动触发下拉函数填充满父盒子
        homeworkLists: []
      }
    },
    components: {
      noList
    },
    created() {
      this.keyword = this.$route.params.keyword
      this.msg = this.keyword
      this.homeworkLists = []
      this.searchFW(1)
    },
    mounted() {
      this.$refs.searchContent.style.height = (document.body.clientHeight - this.$refs.searchBox.offsetHeight - 30) + 'px'
    },
    methods: {
      goBack() {
        BHWEB.pop()
      },
      goHome() { // 返回首页
        BHWEB.popToHomePage()
      },
      clean() {
        this.msg = ''
        this.keyword = ''
        this.$refs.searchAll.focus()
      },
      noFindListImg() {  // 列表图片加载失败
        event.target.src = '/static/listDefault.jpg'
      },
      searchFW(page) {
        if (this.keyword.length < 2) {
          this.info = '抱歉，没有找到相关内容'
          Toast({
            message: '请输入至少两个关键字',
            position: 'middle',
            duration: 1000
          })
          return
        }
        this.$axios.get(this.$httpConfig.keywordsHomework, {
        params: {
            'keywords': this.keyword,
            'page': page,
            'is-highlight': 1
          }
        })
          .then(res => {
            if (res.status == 200) {
              this.pageCount = res.data.pageCount
              this.homeworkLists = this.homeworkLists.concat(res.data.data)
              if(this.homeworkLists.length == 0) {
                this.info = '抱歉，没有找到相关内容'
                return
              } else {
                this.info = ''
              }
              if(this.pageCount == 1) {
                this.allLoaded = true;
              }
            } else {
              Bus.$emit('message', res.data.message);
            }
          })
          .catch(err => Bus.$emit('error', err))
      },
      loadBottom() {
        // 通知组件的状态改变，下拉完成(初始设置)
        this.$refs.loadmore.onBottomLoaded();
        if (this.pageIndex > this.pageCount) {
          Toast({
            message: '已经到底了',
            position: 'bottom',
            duration: 1000
          })
          this.allLoaded = true;
        } else {
          this.searchFW(this.pageIndex++)
        }
      },
      handleBottomChange(s) { // 下拉改变
        // console.log(s);
      },
      toHomework(params) {
        BHWEB.toHomework(params.listId);
      },
      searchKeyWord() {
        if(this.msg.length < 2) {
          this.$refs.searchAll.blur()
          Toast({
            message: '请输入至少两个关键字',
            position: 'middle',
            duration: 1000
          })
          return
        }
        this.$refs.searchAll.blur()
        this.keyword = this.msg
        this.homeworkLists = []
        this.pageIndex = 2
        this.pageCount = 0
        this.allLoaded = false
        this.isAutoFill = false
        this.searchFW(1)
      }
    }
  }
</script>

<style lang="less" scoped>
input[type=search] {
  -webkit-appearance: none;
  -webkit-box-sizing: content-box;
  font-family: inherit;
  font-size: 100%;
}
input::-webkit-search-results-button,
input::-webkit-search-results-decoration,
input::-webkit-search-decoration,
input::-webkit-search-cancel-button {
  display: none;
}

.wrapper {
  width: 100%;
  height: 100%;
  
  overflow: hidden;
}
.searchBox {
  width: 100%;
  font-size: 14px;
  color: #555;
  padding: 0 0.186667rem;
  margin: 0.293333rem 0;
}
.searchAll {
  width: 65%;
  float: left;
  border: none;
  height: 0.86rem;
  text-indent: 1em;
  -webkit-appearance: none!important;
  border-radius: 0.2rem 0 0 0.2rem!important;
}
.serachBtnBox {
  width: 20%;
  height: 0.86rem;
  float: left;
  background-color: #fff;
  border-radius: 0 0.2rem 0.2rem 0;
}
.serachBtnBox img {
  height: 0.46rem;
  display: block;
}
.serachBtnBox .cleanBtn,
.serachBtnBox .searchBtn {
  width: 49%;
}
.serachBtnBox .cleanBtn img,
.serachBtnBox .searchBtn img,
.serachBtnBox .searchLine img {
  margin: 0.20rem auto;
}
.serachBtnBox .searchLine {
  width: 2%;
  text-align: center;
}
.canleBtn {
  width: 15%;
  float: right;
  line-height: 0.86rem;
  text-align: center;
}
.searchContent {
  overflow-y: scroll;
  -webkit-overflow-scrolling: touch;
}
.fineWorkList {
  position: relative;
  padding: 0 0.16rem 0;
}

.fineWorkCtn {
  width: 9.68rem;
  height: 1.96rem;
  margin-bottom: 0.213333rem;
  border-radius: 0.16rem;
  background-color: #ffffff;
}

.fineWorkCtn .titleImg {
  float: left;
  margin-top: 0.546667rem;
  margin-left: 0.6rem;
  width: 0.68rem;
  height: 0.68rem;
}

.fineWorkCtn .titleImg.advance {
  width: 0.706667rem;
  height: 0.68rem;
  background: url(../../../images/advance.png);
  background-size: cover;
  -webkit-background-size: cover;
}

.fineWorkCtn .titleImg.base {
  background: url(../../../images/base.png);
  background-size: cover;
  -webkit-background-size: cover;
}

.fineWorkCtn .titleImg.check {
  background: url(../../../images/check.png);
  background-size: cover;
  -webkit-background-size: cover;
}

.fineWorkCtn p {
  float: left;
  width: 7.4rem;
  margin-top: 0.546667rem;
  margin-left: 0.36rem;
  color: #555555;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}
</style>