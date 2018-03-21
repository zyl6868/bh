<template>
  <div class="wrapper">
  	<div class="searchBox clearfix" ref="searchBox">
      <form action="" enctype='application/json' @submit.prevent="searchKeyWord">
        <input class="searchAll" ref="searchAll" autocomplete="false" autocorrect="false" type="search" name="word" v-model="msg" placeholder="请输入课件或作业关键字"/>
      </form>
      <div class="serachBtnBox clearfix" >
        <div class="cleanBtn fl" v-show="msg.length > 0" @click="goBack">
          <img src="../../images/clean.png">
        </div>
        <div class="searchLine fl" v-show="msg.length > 0">
          <img src="../../images/searchLine.png">
        </div>
        <div class="searchBtn fr" @click="searchKeyWord" v-show="msg.length > 0">
          <img src="../../images/search.png">
        </div>
        <div class="searchBtn fr" v-show="msg.length == 0">
          <img src="../../images/noSearch.png">
        </div>
      </div>
      <div class="canleBtn" @click="goHome">取消</div>
    </div>

    <div class="searchContent" ref="searchContent" v-show="materialLists.length > 0 || homeworkLists.length > 0">
      <div class="commonPart" v-show="materialLists.length > 0">
        <div class="commonTitle">
          <p>课件教案</p>
          <img src="../../images/titleLine.png">
        </div>
        <ul class="coursewareList">
          <router-link :to="{name: 'ResourceDetails', params: {id: list.id}}" tag="li" class="coursewareCtn" v-for="list in materialLists">
            <div class="titleImg">
              <img :src="list.image" @error.once="noFindListImg()" v-show="list.image != null">
              <img src="../../images/listDefault.jpg" v-show="list.image == null">
              <span v-show="list.isBoutique == 1"></span>
            </div>
            <div class="titleCtn">
              <p v-html="list.name"></p>
            </div>
          </router-link>
        </ul>
        <router-link :to="{name: 'SearchCourseware', params: {keyword: keyword}}" tag="div" class="searchMore" v-show="materialLists.length >= 3">
          <img class="fl" src="../../images/search.png">
          <p class="fl">查看更多课件教案</p>
          <img class="fr" src="../../images/go.png" alt="">
        </router-link>
      </div>

      <div class="commonPart" v-show="homeworkLists.length > 0">
        <div class="commonTitle">
          <p>精品作业</p>
          <img src="../../images/titleLine.png">
        </div>
        <ul class="fineWorkList">
            <li class="fineWorkCtn" v-for="lists in homeworkLists" @click="toHomework(lists.id)">
              <div class="titleImg" :class="{base: lists.homeworkType == 2241110, advance: lists.homeworkType == 2241111, check: lists.homeworkType == 2241100}"></div>
              <p v-html="lists.name"></p>
            </li>
          </ul>
        <router-link :to="{name: 'SearchFineWork', params: {keyword: keyword}}" tag="div" class="searchMore" v-show="homeworkLists.length >= 3">
          <img class="fl" src="../../images/search.png">
          <p class="fl">查看更多精品作业</p>
          <img class="fr" src="../../images/go.png" alt="">
        </router-link>
      </div>
    </div>

    <noList v-show="materialLists.length == 0 && homeworkLists.length == 0" :info="info"></noList>
  </div>
</template>

<script>
  import noList from '../Global/NoList/NoList.vue'
  import Bus from '../Global/Bus/bus.js'
  import { Toast } from 'mint-ui'
  export default {
    data() {
      return {
        keyword: '',  // 搜索关键字
      	msg: '',  // input 输入的字段
        info: '',
        materialLists: [], // 课件教案列表
        homeworkLists: [], // 精品作业列表
      }
    },
    created() {
      this.keyword = this.$route.params.keyword
      this.msg = this.keyword
      this.searchAll()
    },
    components: {
      noList
    },
    mounted() {
      this.$refs.searchContent.style.maxHeight = (document.body.clientHeight - this.$refs.searchBox.offsetHeight - 30) + 'px'
    },
    methods: {
      noFindListImg() {  // 列表图片加载失败
        event.target.src = '/static/listDefault.jpg'
      },
      goBack() {  // 返回
        BHWEB.pop()
      },
      goHome() { // 返回首页
        BHWEB.popToHomePage()
      },
      searchAll() {  // 发送请求搜索全部
        if (this.keyword.length < 2) {
          this.info = '抱歉，没有找到相关内容'
          Toast({
            message: '请输入至少两个关键字',
            position: 'middle',
            duration: 1000
          })
          return;
        }
        this.materialLists = []
        this.homeworkLists = []
        this.$axios.get(this.$httpConfig.keywordsAll, {
          params: {
            'keywords': this.keyword,
            'per-page': 3,
            'is-highlight': 1
          }
        })
          .then(res => {
            if (res.status == 200) {
              this.materialLists = res.data.materialList.data
              this.homeworkLists = res.data.homeworkList.data
              if(this.materialLists.length == 0 && this.homeworkLists.length == 0) {
                this.info = '抱歉，没有找到相关内容'
              } else {
                this.info = ''
              }
            } else {
              Bus.$emit('message', res.data.message);
            }
          })
          .catch(err => Bus.$emit('error', err))
      },
      toHomework(id) {
        BHWEB.toHomework(id);
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
        this.searchAll()
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
  padding: 0 0.186667rem;
  overflow: hidden;
}
.searchBox {
  width: 100%;
  font-size: 14px;
  color: #555;
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

.commonPart {
  border-radius: 0.16rem;
  margin-bottom: 0.266667rem;
}
.commonPart .commonTitle {
  height: 0.98rem;
  position: relative;
  padding: 0.1rem 0.453333rem 0;
  background-color: #fff;
  border-radius: 0.16rem 0.16rem 0 0;
}
.commonPart .commonTitle p {
  font-size: 16px;
  color: #555;
  line-height: 0.86rem;
  border-bottom: 1px solid #d2d2d2;
}
.commonPart .commonTitle img {
  display: block;
  height: 12px;
  position: absolute;
  top: 0.35rem;
  left: 0.26rem;
}
.coursewareList {
  position: relative;
  padding: 0 0.453333rem; 
  background-color: #ffffff;
}
.coursewareCtn {
  width: 100%;
  height: 2.7rem;
  padding: 0.1rem 0 0.2rem;
  border-bottom: 1px solid #d2d2d2;
}
.coursewareCtn:last-child {
  border-bottom: none;
}
.coursewareCtn .titleImg {
  float: left;
  margin-top: 0.25rem;
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
  background: url(../../images/crown.png);
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
  width: 5rem;
  margin-top: 0.413333rem;
  margin-left: 0.36rem;
  font-size: 14px;
  color: #555;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
}
.searchMore {
  height: 0.98rem;
  line-height: 0.98rem;
  font-size: 14px;
  color: #2a51ed;
  padding: 0 0.26rem;
  background-color: #d2dbff;
  border-radius: 0 0 0.16rem 0.16rem;
}
.searchMore img {
  height: 16px;
  margin-top: 0.28rem;
}
.searchMore p {
  margin-left: 0.2rem;
}


.fineWorkList {
  position: relative;
  padding: 0 0.453333rem;
  background-color: #ffffff;
}

.fineWorkCtn {
  height: 1.96rem;
  border-bottom: 1px solid #d2d2d2;
}

.fineWorkCtn:last-child {
  border-bottom: none;
}

.fineWorkCtn .titleImg {
  float: left;
  margin-top: 0.546667rem;
  width: 0.68rem;
  height: 0.68rem;
}

.fineWorkCtn .titleImg.advance {
  width: 0.706667rem;
  height: 0.68rem;
  background: url(../../images/advance.png);
  background-size: cover;
  -webkit-background-size: cover;
}

.fineWorkCtn .titleImg.base {
  background: url(../../images/base.png);
  background-size: cover;
  -webkit-background-size: cover;
}

.fineWorkCtn .titleImg.check {
  background: url(../../images/check.png);
  background-size: cover;
  -webkit-background-size: cover;
}

.fineWorkCtn p {
  float: left;
  width: 7.64rem;
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