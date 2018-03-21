<template>
  <div class="wraper">
    <div class="tabBar">
      <div class="header">
        <div class="back" @click="goback">
          <img src="../../images/back.png">
        </div>
        <div class="title">
          <h4>资源详情</h4>
        </div>
      </div>
      <div class="garyBg"></div>
    </div>
		<div class="fileFormat">
			<i class="iconfont ppt" v-show="detail.fileType == 'ppt'">&#xe617;</i>
			<i class="iconfont word" v-show="detail.fileType == 'word'">&#xe66d;</i>
			<span v-show="detail.isBoutique == 1"></span>
		</div>
		<p class="ResourceDes">{{detail.name}}</p>
		<div class="fileSize"></div>
		<a class="fileBtn" href="javascript:;" @click="toPreview"><i class="iconfont">&#xe683;</i>&nbsp;&nbsp;&nbsp;预览</a>
		<a class="fileBtn" href="javascript:;" :class="{gary: collected == '取消收藏'}" @click="collecte"><i class="iconfont">&#xe501;</i>&nbsp;&nbsp;&nbsp;{{collected}}</a>
    <a class="fileBtn" href="javascript:;" @click="toDownload"><i class="iconfont">&#xe615;</i>&nbsp;&nbsp;&nbsp;下载</a>
		<a class="fileBtn" href="javascript:;" @click="shareScreen" ><img class="shareScreen" src="../../images/shareScreen.png">&nbsp;&nbsp;&nbsp;投屏</a>
  </div>
</template>

<script>
	import Bus from '../Global/Bus/bus.js'
  import isLogin from '../../util/isLogin.js'
  import { Toast, MessageBox } from 'mint-ui'
  export default {
    data() {
      return {
        id: 0,
      	detail: {},
      	preview: '',  // 预览地址
      	download: '', // 下载地址
        shareScreenUrl: '', // 预览地址
      	collected: '收藏', // 收藏按钮内容
        // historyLength: 0, // history长度
        // isMinus: false, // 是否要减
      }
    },
    // beforeRouteEnter(to, from ,next) {
    //   next(vm => {
    //     console.log(from.name)
    //     if (from.name == 'ShareScreen') {
    //       vm.isMinus = true;
    //     }
    //   })
    // },
    created() {
    	this.id = this.$route.params.id;
    	this.id = this.id.toString();
    	// 资源详情列表
    	this.$axios.get(this.$httpConfig.csMaterialDetail + this.id)
    		.then(res => {
    			if (res.status == 200) {
    				this.detail = res.data;
    			} else {
    				Bus.$emit('message', res.data.message);
    			}
    		})
    		.catch(err => Bus.$emit('error', err))
    	
      if (!isLogin) {
        this.collected = '收藏'
      } else {
        this.$axios.get(this.$httpConfig.csMaterialIsCollected + this.id)
          .then(res => {
            if (res.status == 200) {
              if (res.data.length > 0) {
                this.collected = '取消收藏'
              }
            } else {
              Bus.$emit('message', res.data.message);
            }
          })
          .catch(err => Bus.$emit('error', err))
      }
    	
    },
    methods: {
    	collecte() {  // 收藏
    		if (!isLogin) {
          BHWEB.action('toLogin', '')
        } else {
          // 如果未收藏
          if (this.collected == '收藏') {
            this.$axios.post(this.$httpConfig.csMaterial_collect, {
              'file-id': this.detail.id
            })
              .then(res => {
                if (res.status == 200) {
                  // 改变为取消收藏
                  this.collected = '取消收藏'
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
                  });
                } else {
                  Bus.$emit('error', err)
                }
              })
          } else { //如果已收藏
            this.$axios.post(this.$httpConfig.csMaterialCancleCollect, {
              'file-id': this.detail.id
            })
              .then(res => {
                if (res.status == 200) {
                  // 改变为取消收藏
                  this.collected = '收藏'
                } else {
                  Bus.$emit('message', res.data.message);
                }
              })
              .catch(err => Bus.$emit('error', err))
          }
        }
    	},
      toPreview() {   // 预览
        if (!isLogin) {
          // 调登录方法
          BHWEB.action('toLogin', '')
        } else {
          // 预览操作
          this.$axios.get(this.$httpConfig.csMaterialPreview + this.id)
            .then(res => {
              if (res.status == 200) {
                this.preview = res.data;
                BHWEB.action('toPreview', this.preview);
              } else {
                Bus.$emit('message', res.data.message);
              }
            })
            .catch(err => {
              if (err.response.status == 403) {
                console.dir(err)
                MessageBox({
                  title: '提示',
                  message: err.response.data.message,
                  showCancelButton: true,
                  confirmButtonText: '知道了',
                  showCancelButton: false
                });
              } else {
                Bus.$emit('error', err)
              }
            })
        }
        
      },
      toDownload() {  // 下载
        if (!isLogin) {
          BHWEB.action('toLogin', '')
        } else {
          // 下载操作
          this.$axios.post(this.$httpConfig.csMaterialDownload, {
            'file-id': this.id
          })
            .then(res => {
              if (res.status == 200) {
                this.download = res.data;
                BHWEB.action('download', this.download);
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
                });
              } else {
                Bus.$emit('error', err)
              }
            })
        }
      },
      shareScreen() {  // 投屏
        if (!isLogin) {
          BHWEB.action('toLogin', '')
        } else {
          this.$axios.get(this.$httpConfig.csMaterialShow + this.id)
            .then(res => {
              if (res.status == 200) {
                this.shareScreenUrl = res.data
                this.$router.push({name: 'ShareScreen', params: {id: this.id, url: this.shareScreenUrl}})
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
                });
              } else {
                Bus.$emit('error', err)
              }
            })
        }
      },
      goback() {      // 返回
        // if (this.isMinus) {
        //   if (this.historyLength > 1) {
        //     this.historyLength -= 1
        //   }
        // }
        // console.log('处理后' + this.historyLength)
        // if (this.historyLength <= 1) {
        //   BHWEB.action('pop', '')
        // } else {
        //   this.$router.go(-1)
        // }
        
        if(BHWEB.resourceScan && typeof(BHWEB.resourceScan) === "function") {
          BHWEB.action('appGoBack', '')
        } else { //不是函数
          this.$router.go(-1)
        }
      }
    }
  }
</script>

<style lang="less" scoped>
.wraper {
	height: 100%;
}
.tabBar {
  width: 100%;
}
.header {
  height: 1.866667rem;
  border-bottom: 1px solid #dfdfdf;
  overflow: hidden;
  background-color: #fff;
}
.header .back {
  width: 1.066667rem;
  height: 1.866667rem;
  position: relative;
  z-index: 1000;
  text-align: center;
}

.header .back img {
  margin-top: 0.8rem;
  width: 0.346667rem;
  height: 0.613333rem;
}
.header .title {
  width: 5.333333rem;
  position: absolute;
  top: 0.75rem;
  left: 50%;
  margin-left: -2.666667rem;
  text-align: center;
}
.header .title h4 {
  font-size: 20px;
  color: #585858;
  font-weight: 400;
}
.garyBg {
  height: 0.293333rem;
  background-color: #e8e8e8;
}
.fileFormat {
	margin: 1.573333rem auto 0.5rem;
	width: 1.066667rem;
	height: 1.066667rem;
	position: relative;
}
.fileFormat i {
	font-size: 40px;
}
.fileFormat .ppt {
	color: #ff4949;
}
.fileFormat .word {
	color: #0e99ff;
}
.fileFormat span {
	display: block;
	width: 0.586667rem;
	height: 0.546667rem;
	background: url(../../images/crown.png);
	background-size: cover;
	-webkit-background-size: cover;
	position: absolute;
	top: -0.4rem;
	right: -0.4rem;

}
.ResourceDes {
	margin: 0 auto;
	width: 80%;
	color: #585858;
	font-size: 14px;
    text-align: center;
}
.fileSize {
	margin-top: 0.4rem;
	margin-bottom: 0.906667rem;
	text-align: center;
	color: #999;
	font-size: 14px;
}
.fileBtn {
	display: block;
	width: 50%;
	height: 1.066667rem;
	line-height: 1.066667rem;
	border: 1px solid #91a5f3;
	border-radius: 0.533333rem;
	margin: 0 auto 0.666667rem;
	font-size: 16px;
	color: #2a51ed;
	text-align: center;
}
.fileBtn.gary {
	color: #999;
	border: 1px solid #999;
}
.fileBtn .shareScreen {
  width: 0.466667rem;
  vertical-align: middle;
}
a {
	text-decoration: none;
}
</style>