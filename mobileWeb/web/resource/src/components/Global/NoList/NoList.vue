<template>
  <div class="wrapper">
		<img src="/static/noList.png" alt="">
		<p>{{info}}</p>
  </div>
</template>

<script>
  export default {
    data() {
      return {

      }
    },
    props: ['info'],
  }
</script>

<style lang="less" scoped>
.wrapper {
	text-align: center;
}
.wrapper img {
	width: 2.586667rem;
	height: 2.346667rem;
	margin-top: 3.2rem;
}
.wrapper p{
	margin-top: 0.533333rem;
	font-size: 14px;
	color: #555;
}
</style>