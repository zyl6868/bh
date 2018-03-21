<template>
  <div class="wraper">
		<div class="fileFormat">
			<i class="iconfont ppt" v-show="detail.fileType == 'ppt'">&#xe617;</i>
			<i class="iconfont word" v-show="detail.fileType == 'word'">&#xe66d;</i>
      <img src="../../images/other.png" v-show="detail.fileType != 'word' && detail.fileType != 'ppt'">
			<span v-show="detail.isBoutique == 1"></span>
		</div>
		<p class="ResourceDes">{{detail.name}}</p>
		<div class="fileSize"></div>
		<a class="fileBtn" href="javascript:;" @click="login(previewHandle)"><i class="iconfont">&#xe683;</i>&nbsp;&nbsp;&nbsp;预览</a>
		<a class="fileBtn" href="javascript:;" :class="{gary: collected == '取消收藏'}" @click="login(collecteHandle)"><i class="iconfont">&#xe501;</i>&nbsp;&nbsp;&nbsp;{{collected}}</a>
    <a class="fileBtn" href="javascript:;" @click="login(downloadHandle)"><i class="iconfont">&#xe615;</i>&nbsp;&nbsp;&nbsp;下载</a>
		<a class="fileBtn" href="javascript:;" @click="login(shareScreenHandle)" ><img class="shareScreen" src="../../images/shareScreen.png">&nbsp;&nbsp;&nbsp;投屏</a>
  </div>
</template>

<script>
	import Bus from '../Global/Bus/bus.js'
  import { Toast, MessageBox } from 'mint-ui'
  import { getCookie } from '../../util/cookie.js'
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
    //       vm.isMinus = true
    //     }
    //   })
    // },
    created() {
    	this.id = this.$route.params.id
    	this.id = this.id.toString()
    	// 资源详情列表
    	this.$axios.get(this.$httpConfig.csMaterialDetail + this.id)
    		.then(res => {
    			if (res.status == 200) {
    				this.detail = res.data
    			} else {
    				Bus.$emit('message', res.data.message)
    			}
    		})
    		.catch(err => Bus.$emit('error', err))
    	
      if (!getCookie('auth')) {
        this.collected = '收藏'
      } else {
        this.$axios.get(this.$httpConfig.csMaterialIsCollected + this.id)
          .then(res => {
            if (res.status == 200) {
              if (res.data.length > 0) {
                this.collected = '取消收藏'
              }
            } else {
              Bus.$emit('message', res.data.message)
            }
          })
          .catch(err => Bus.$emit('error', err))
      }
    	
    },
    methods: {
      login(callback) {  // 登录
        if (getCookie('auth')) {
          callback()
          return
        }

        let _this = this;
        window.loginHandle = function () {
          let token = BHWEB.getToken()
          if (token) {
            _this.$axios.get(_this.$httpConfig.siteLogin + token)
              .then(res => {
                if (res.status == 200) {
                  callback()
                }
              })
              .catch(err => {
                if (err.response.status == 401) {
                  BHWEB.tokenInvalid()
                }
              })
          }
        }

        if (BHWEB.getToken()) {
         loginHandle();
        } else {
         BHWEB.userLogin('loginHandle()') 
        }
      },
      previewHandle() { // 预览操作
        // 预览操作
        this.$axios.get(this.$httpConfig.csMaterialPreview + this.id)
          .then(res => {
            if (res.status == 200) {
              this.preview = res.data
              BHWEB.toPreview(this.preview)
            } else {
              Bus.$emit('message', res.data.message)
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
      collecteHandle() {  // 收藏
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
                  Bus.$emit('message', res.data.message)
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
          } else { //如果已收藏
            this.$axios.post(this.$httpConfig.csMaterialCancleCollect, {
              'file-id': this.detail.id
            })
              .then(res => {
                if (res.status == 200) {
                  // 改变为取消收藏
                  this.collected = '收藏'
                } else {
                  Bus.$emit('message', res.data.message)
                }
              })
              .catch(err => Bus.$emit('error', err))
          }
      },
      downloadHandle() {  // 下载操作
        // 是精品课件
        if (this.detail.isBoutique == 1) {
          this.$axios.get(this.$httpConfig.csUserLevel)
            .then(res => {
              if (res.data.memberLevel == 0) {
                MessageBox({
                  title: '提示',
                  message: '抱歉,此资源为高级会员专属,普通用户不能下载.',
                  showCancelButton: true,
                  confirmButtonText: '知道了',
                  showCancelButton: false
                })
                  .then(action => {
                    if (action === 'confirm') {
                      try {
                        if (BHWEB.toBeHaikeVIP && typeof(BHWEB.toBeHaikeVIP) == 'function') {
                          BHWEB.toBeHaikeVIP();
                        }
                      } catch(e) {
                        return;
                      }
                    }
                  })
              } else {
                MessageBox({
                  title: '下载消耗学米',
                  message: '<p>普通会员：'+ this.detail.price +'学米</p><p>高级会员：' + Math.ceil(this.detail.price / 2) + '学米</p>',
                  showCancelButton: true,
                  confirmButtonText: '确定',
                  showCancelButton: true
                })
                  .then(action => {
                    if (action === 'confirm') {
                      // 下载操作
                      this.$axios.post(this.$httpConfig.csMaterialDownload, {
                        'file-id': this.id
                      })
                        .then(res => {
                          if (res.status == 200) {
                            this.download = res.data
                            BHWEB.download(this.download)
                          } else {
                            Bus.$emit('message', res.data.message)
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
                    }
                  })
              }
            })
            .catch(err => Bus.$emit('error', err))
        } else {
          MessageBox({
            title: '下载消耗学米',
            message: '<p>普通会员：'+ this.detail.price +'学米</p><p>高级会员：' + Math.ceil(this.detail.price / 2) + '学米</p>',
            showCancelButton: true,
            confirmButtonText: '确定',
            showCancelButton: true
          })
            .then(action => {
              if (action === 'confirm') {
                // 下载操作
                this.$axios.post(this.$httpConfig.csMaterialDownload, {
                  'file-id': this.id
                })
                  .then(res => {
                    if (res.status == 200) {
                      this.download = res.data
                      BHWEB.download(this.download)
                    } else {
                      Bus.$emit('message', res.data.message)
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
              }
            })
        }
      },
      shareScreenHandle() {  // 投屏操作
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
              })
            } else {
              Bus.$emit('error', err)
            }
          })
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
.wraper {
	height: 100%;
  overflow: hidden;
}
.fileFormat {
	margin: 1.573333rem auto 0.5rem;
	width: 1.066667rem;
	height: 1.066667rem;
	position: relative;
}
.fileFormat img {
  width: 40px;
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