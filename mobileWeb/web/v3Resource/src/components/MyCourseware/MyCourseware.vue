
<template>
  <div class="wrapper">
    <div class="myCoursewareBox" v-show="coursewareList.length > 0" ref="myCoursewareBox">
      <mt-loadmore :bottom-method="loadBottom" :bottom-all-loaded="allLoaded" ref="loadmore" @bottom-status-change="handleBottomChange" :auto-fill="isAutoFill">
        <ul class="myCoursewareList">
          <li class="myCoursewareCtn" v-for="(items, index) in coursewareList">
            <div class="upPage">
              <div class="ctnInfo" v-tap="{methods: preview, id: items.material.id}">
                <div class="titleImg">
                  <i class="iconfont word" v-show="items.material.fileType == 'word'">&#xe66d;</i>
                  <i class="iconfont ppt" v-show="items.material.fileType == 'ppt'">&#xe617;</i>
                  <i class="other" v-show="items.material.fileType != 'ppt' && items.material.fileType != 'word'"></i>
                </div>
                <p>{{items.material.name}}</p>
              </div>
              <i class="iconfont upOrDown" v-html="items.upOrDown" v-tap="{methods: down, index: index}"></i>
            </div>
            <div class="handle" v-show="items.isSelect">
              <div class="btn" @click="download(items.favoriteId)">
                <img src="../../images/download.png">
                <span>下载</span>
              </div>
              <div class="btn" @click="shareScreen(items.favoriteId)">
                <img src="../../images/shareScreen.png">
                <span>投屏</span>
              </div>
              <div class="btn" @click="deleted(items.favoriteId, index)">
                <img src="../../images/delete.png">
                <span style="color: #999;">删除</span>
              </div>
            </div>
          </li>
        </ul>
      </mt-loadmore>
    </div>
    <noList v-show="coursewareList.length == 0" :info="info"></noList>
  </div>
</template>
<script>
import Bus from '../Global/Bus/bus.js'
import noList from '../Global/NoList/NoList.vue'
import { Toast, MessageBox } from 'mint-ui'
import isLogin from '../../util/isLogin.js'
export default {
  data() {
    return {
      info: '',
      title: '课件教案',
      pageIndex: 1, // 页数
      pageCount: 0, // 总页数
      coursewareList: [], // 课件教案列表
      pageCount: 0, // 总计页数
      allLoaded: false, // 允许再次调用上拉函数
      isAutoFill: false, // 是否自动触发下拉函数填充满父盒子
    }
  },
  components: {
    noList
  },
  created() {
    this.getLists()
  },
  mounted() {
    this.$refs.myCoursewareBox.style.height = (document.body.clientHeight - 20) + 'px';
  },
  methods: {
    initCourseWare(obj) { // 初始化列表数据
      obj.forEach(ele => {
        ele.isSelect = false
  			ele.upOrDown = '&#xe632'
      })
    },
    down(params) {
    	if (this.coursewareList[params.index].isSelect) {
    		this.initCourseWare(this.coursewareList)
	      this.coursewareList[params.index].isSelect = false;
	      this.coursewareList[params.index].upOrDown = '&#xe632';
    	} else {
    		this.initCourseWare(this.coursewareList)
	      this.coursewareList[params.index].isSelect = true;
	      this.coursewareList[params.index].upOrDown = '&#xe604';
    	}
      
    },
    preview(params) {
      // 预览操作
      this.$axios.get(this.$httpConfig.csMaterialPreview + params.id)
        .then(res => {
          if (res.status == 200) {
            BHWEB.toPreview(res.data);
          } else {
            Bus.$emit('message', res.data.message);
          }
        })
        .catch(err => {
          if (err.response.status == 403) {
            MessageBox({
              title: '提示',
              message: err.response.data.message,
              showCancelButton: true,
              confirmButtonText: '知道了',
              showCancelButton: false
            })
          } else {
            Bus.$emit('error', err)
          }
        })
    },
    download(id) { // 下载操作
      this.$axios.post(this.$httpConfig.csMaterialDownload, {
          'file-id': id
        })
        .then(res => {
          if (res.status == 200) {
            BHWEB.download(res.data);
          } else {
            Bus.$emit('message', res.data.message);
          }
        })
        .catch(err => {
          if (err.response.status == 403) {
            MessageBox({
              title: '提示',
              message: err.response.data.message,
              showCancelButton: true,
              confirmButtonText: '知道了',
              showCancelButton: false
            })
          } else {
            Bus.$emit('error', err)
          }
        })
    },
    shareScreen(id) { // 投屏操作
      this.$axios.get(this.$httpConfig.csMaterialShow + id)
        .then(res => {
          if (res.status == 200) {
            this.$router.push({name: 'ShareScreen', params: {id: id, url: res.data}})
          } else {
            Bus.$emit('message', res.data.message);
          }
        })
        .catch(err => {
          if (err.response.status == 403) {
            MessageBox({
              title: '提示',
              message: err.response.data.message,
              showCancelButton: true,
              confirmButtonText: '知道了',
              showCancelButton: false
            })
          } else {
            Bus.$emit('error', err)
          }
        })
    },
    deleted(id, index) { // 删除操作
      this.$axios.post(this.$httpConfig.csMaterialCancleCollect, {
          'file-id': id
        })
        .then(res => {
          if (res.status == 200) {
            // 取消收藏成功
            this.coursewareList.splice(index, 1);
            Toast({
              message: '删除成功',
              position: 'middle',
              duration: 1000
            })
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
        this.getLists()
      }
    },
    handleBottomChange(s) {
      // console.log(s);
    },
    getLists() {
      this.$axios.get(this.$httpConfig.csMaterialCollect + this.pageIndex++)
        .then(res => {
          if (res.status == 200) {
            this.pageCount = res.data['_meta'].pageCount;
            if (this.pageCount == 1 || !this.pageCount) {
              this.allLoaded = true;
            }
            this.initCourseWare(res.data.items)
            this.coursewareList = this.coursewareList.concat(res.data.items);
          } else {
            Bus.$emit('message', res.data.message);
          }
        })
        .catch(err => Bus.$emit('error', err))
    }
  }
}

</script>
<style lang="less" scoped>
* {
  -webkit-user-select: none; /*不允许用户选中文字*/
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.wrapper {
  width: 100%;
  height: 100%;
}

.myCoursewareBox {
  position: relative;
  height: 82%;
  overflow-y: scroll;
  -webkit-overflow-scrolling: touch;
}

.myCoursewareList {
  padding: 0.266667rem 0.16rem 0;
}

.myCoursewareCtn {
  margin-bottom: 0.453333rem;
}

.myCoursewareCtn .upPage {
  width: 9.68rem;
  height: 1.96rem;
  position: relative;
  z-index: 1;
  border-radius: 0.16rem;
  background-color: #ffffff;
}

.myCoursewareCtn .upPage .ctnInfo {
  height: 1.8rem;
  float: left;
}

.myCoursewareCtn .titleImg {
  float: left;
  margin-top: 0.453333rem;
  margin-left: 0.6rem;
  width: 1.04rem;
  height: 1.04rem;
}

.myCoursewareCtn .titleImg i {
  font-size: 38px;
}

.myCoursewareCtn .titleImg .word {
  color: #0094fe;
}

.myCoursewareCtn .titleImg .ppt {
  color: #ff4949;
}
.myCoursewareCtn .titleImg .other {
	display: inline-block;
	width: 1.04rem;
  height: 1.04rem;
  background: url(../../images/other.png);
  background-size: cover;
  -webkit-background-size: cover;
}
.myCoursewareCtn p {
  float: left;
  width: 6.4rem;
  margin-top: 0.546667rem;
  margin-left: 0.36rem;
  color: #555555;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}

.myCoursewareCtn .upOrDown {
  float: right;
  color: #2a51ed;
  font-size: 22px;
  margin: 0.586667rem 0.266667rem 0 0;
}

.myCoursewareCtn .handle {
  width: 9.666667rem;
  height: 1.706667rem;
  background-color: #e8e8e8;
  margin-top: -0.133333rem;
  border-radius: 0 0 0.16rem 0.16rem;
  padding: 0.4rem 0.8rem 0;
}

.myCoursewareCtn .handle .btn {
  float: left;
  width: 33%;
  text-align: center;
}

.myCoursewareCtn .handle .btn img {
  display: block;
  margin: 0 auto 0.133333rem;
  height: 0.573333rem;
}

.myCoursewareCtn .handle .btn span {
  color: #2a51ed;
}
</style>
