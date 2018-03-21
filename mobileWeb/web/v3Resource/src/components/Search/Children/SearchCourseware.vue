<template>
  <div class="wrapper">
    <div class="searchBox clearfix" ref="searchBox">
      <form action="" method="get" enctype='application/json' @submit.prevent="searchKeyWord" >
        <input class="searchAll" ref="searchAll" type="search" name="word" autocomplete="false" autocorrect="false" v-model="msg" placeholder="搜索课件教案" />
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

    <div ref="searchContent" class="searchContent" v-show="materialLists.length > 0">
      <mt-loadmore :bottom-method="loadBottom" :bottom-all-loaded="allLoaded" ref="loadmore" @bottom-status-change="handleBottomChange" :auto-fill="isAutoFill">
        <ul class="coursewareList">
          <li class="coursewareCtn" v-for="list in materialLists" v-tap="{methods: routerLink, listId: list.id}">
            <div class="titleImg">
              <img :src="list.image" @error.once="noFindListImg()" v-show="list.image != null">
              <img src="../../../images/listDefault.jpg" v-show="list.image == null">
              <span v-show="list.isBoutique == 1"></span>
            </div>
            <div class="titleCtn">
              <p v-html="list.name"></p>
            </div>
          </li>
        </ul>
      </mt-loadmore>
    </div>
    <noList v-show="materialLists.length == 0" :info="info"></noList>
  </div>
</template>

<script>
  import noList from '../../Global/NoList/NoList.vue'
  import Bus from '../../Global/Bus/bus.js'
  import { Toast } from 'mint-ui'
  import { getCookie, setCookie, delCookie } from '../../../util/cookie.js'
  export default {
    data() {
      return {
        msg: '',
        keyword: '',
        info: '抱歉，没有找到相关内容',
        pageIndex: 2, // 页码
        pageCount: 0, // 总页数
        allLoaded: false, // 允许再次调用上拉函数
        isAutoFill: false, // 是否自动触发下拉函数填充满父盒子
        materialLists: []
      }
    },
    components: {
      noList
    },
    beforeRouteEnter(to, from, next) {
      if(from.name == 'ResourceDetails') {
        next(vm => {

          vm.$refs.searchContent.scrollTop = getCookie('searchScrollTop');
        })
      } else {
        next(vm => {
          vm.keyword = vm.$route.params.keyword
          vm.msg = vm.keyword
          vm.materialLists = []
          vm.searchCW(1)
        })
      }
      
    },
    created() {
      
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
      searchCW(page) {
        if (this.keyword.length < 2) {
          this.info = '抱歉，没有找到相关内容'
          Toast({
            message: '请输入至少两个关键字',
            position: 'middle',
            duration: 1000
          })
          return
        }
        this.$axios.get(this.$httpConfig.keywordsMaterial, {
          params: {
            'keywords': this.keyword,
            'page': page,
            'is-highlight': 1
          }
        })
          .then(res => {
            if (res.status == 200) {
              this.pageCount = res.data.pageCount
              this.materialLists = this.materialLists.concat(res.data.data)
              if(this.materialLists.length == 0) {
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
          this.searchCW(this.pageIndex++)
        }
      },
      handleBottomChange(s) { // 下拉改变
        // console.log(s);
      },
      routerLink(params) {
        delCookie('searchScrollTop')
        setCookie('searchScrollTop', event.target.offsetTop - params.event.changedTouches[0].pageY + this.$refs.searchContent.offsetTop, 60)
        this.$router.push({name: 'ResourceDetails', params: {id: params.listId}})
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
        this.materialLists = []
        this.pageIndex = 2
        this.pageCount = 0
        this.allLoaded = false
        this.isAutoFill = false
        this.searchCW(1)
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
.coursewareList {
  position: relative;
  padding: 0 0.16rem 0;
}

.coursewareCtn {
  width: 9.68rem;
  height: 2.546667rem;
  margin-bottom: 0.213333rem;
  border-radius: 0.16rem;
  background-color: #ffffff;
}

.coursewareCtn .titleImg {
  float: left;
  margin-top: 0.25rem;
  margin-left: 0.453333rem;
  width: 3.333333rem;
  height: 2.093333rem;
  position: relative;
}

.coursewareCtn .titleImg img {
  width: 3.333333rem;
  height: 2.093333rem;
}

.coursewareCtn .titleImg span {
  display: block;
  width: 0.586667rem;
  height: 0.546667rem;
  background: url(../../../images/crown.png);
  background-size: cover;
  -webkit-background-size: cover;
  position: absolute;
  top: -0.266667rem;
  right: -0.266667rem;
}
.coursewareCtn .titleCtn {
  float: left;
  height: 1.4rem;
}
.coursewareCtn p {
  width: 5.4rem;
  margin-top: 0.413333rem;
  margin-left: 0.36rem;
  color: #555555;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}
</style>