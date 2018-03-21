<template>
  <div class="wrapper">
		<div class="tabBar">
      <div class="header">
        <div class="back" @click="goBack">
          <img src="../../../images/back.png">
        </div>
        <div class="title">
          <h4>投屏</h4>
          <p>在电脑上播放此资源</p>
        </div>
      </div>
    </div>
    <div class="shareScreen">
      <img class="scanShow" src="../../../images/scanShow.png">
    	<p class="shareTitle">1.在电脑浏览器中访问以下地址</p>
    	<p>tp.banhai.com</p>
    	<p class="shareTitle">2.扫描投屏二维码</p>
    	<div class="scan" @click="scan">
    		<img src="../../../images/scan.png">
    		<p>扫一扫</p>
    	</div>
    </div>


  </div>
</template>

<script>
  import { Toast } from 'mint-ui'
  export default {
    data() {
      return {

      }
    },
    created() {

    },
    methods: {
    	scan() {
    		let params = {};
    		params.url = (this.$route.params.url).toString()
    		params.materialId = (this.$route.params.id).toString()
    		params.type = 0
        if(BHWEB.resourceScan && typeof(BHWEB.resourceScan) === "function") {
          BHWEB.resourceScan(JSON.stringify(params))
        } else { //不是函数
          Toast({
            message: '暂未开放，敬请期待',
            position: 'middle',
            duration: 2000
          })
        }

    	},
      goBack() {
        BHWEB.appGoBack()
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
  top: 0.54rem;
  left: 50%;
  margin-left: -2.666667rem;
  text-align: center;
}
.header .title h4 {
  font-size: 18px;
  color: #585858;
  font-weight: 400;
}
.header .title p {
	font-size: 12px;
	color: #999;
}
.shareScreen {
	width: 100%;
	text-align: center;
	color: #2a51ed;
}
.shareScreen p {
  font-size: 14px;
}
.shareScreen .scanShow {
  width: 100%;
}
.shareScreen .shareTitle {
	font-size: 14px;
	color: #555;
	margin: 1rem 0 0.266667rem;
}
.shareScreen .scan {
	margin: 0 auto;
	width: 2rem;
}
.shareScreen .scan img {
	width: 0.773333rem;
}
@media screen and (max-width: 320px) {
  .header .title p {
    margin-top: -0.133333rem;
  }
}
</style>