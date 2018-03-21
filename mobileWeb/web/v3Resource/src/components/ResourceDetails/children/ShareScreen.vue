<template>
  <div class="wrapper">
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