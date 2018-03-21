<template>
  <div class="wrapper">
		<div class="header">
      <div class="back" @click="goBack">
        <img src="../../images/back.png">
      </div>
      <div class="title">
        <h4>更多推荐</h4>
      </div>
	  </div>
	  <div class="darkBg"></div>
		<div class="moreRecommendBox" v-show="recommendList.length > 0" ref="coursewareList">
			<mt-loadmore :bottom-method="loadBottom" :bottom-all-loaded="allLoaded" ref="loadmore" @bottom-status-change="handleBottomChange" :auto-fill="isAutoFill">
				<ul class="moreRecommendList">
					<li class="moreRecommendCtn" v-for="items in recommendList" v-tap="{methods: routerLink, id: items.id}">
						<div class="titleImg">
              <img :src="items.image" @error.once="noFindListImg()" v-show="items.image != null">
              <img src="../../images/listDefault.jpg" v-show="items.image == null">
              <img class="crown" src="../../images/crown.png">
						</div>
						<div class="titleCtn">
							<p>{{items.name}}</p>
						</div>
						<div class="bottomLabel">
							<div class="subjectLabel" v-show="items.subjectName != ''">{{items.subjectName}} </div>
							<div class="timeLabel">{{items.createTime | converTime}}</div>
						</div>
					</li>
				</ul>
			</mt-loadmore>
		</div>
    <noList v-show="recommendList.length == 0" :info="info"></noList>
  </div>
</template>

<script>
  import noList from '../Global/NoList/NoList.vue'
	import Bus from '../Global/Bus/bus.js'
  import { Toast } from 'mint-ui'
  import { setCookie, getCookie, delCookie } from '../../util/cookie.js'
  import isLogin from '../../util/isLogin.js'
  export default {
    data() {
      return {
        info: '',
      	recommendList: [],  // 推荐列表
      	pageIndex: 1, // 页数
      	pageCount: 0, // 总页数
      	allLoaded: false, // 允许再次调用上拉函数
      	isAutoFill: false, // 是否自动触发下拉函数填充满父盒子
      }
    },
    beforeRouteEnter(to, from, next) {
      if(from.name == 'ResourceDetails') {
        next(vm => {
          vm.$refs.coursewareList.scrollTop = getCookie('moreScrollTop');
        })
      } else {
        next()
      }
      
    },
    created() {
      if (!isLogin) {
        // BHWEB.action('pop', '');
      }
    	this.getLists();
    },
    components: {
      noList
    },
    methods: {
      noFindListImg() {  // 列表图片加载失败
        event.target.src = '/static/listDefault.jpg'
      },
    	goBack() {
    		BHWEB.action('pop', '');
    	},
    	loadBottom() {  // 下拉操作
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
    		this.$axios.get(this.$httpConfig.csMaterialRecommend + this.pageIndex++)
    		.then(res => {
    			if (res.status == 200) {
    				this.pageCount = res.data['_meta'].pageCount;
    				if (this.pageCount == 1 || !this.pageCount) {
		    			this.allLoaded = true;
		    		}
    				this.recommendList = this.recommendList.concat(res.data.items);
    			} else {
    				Bus.$emit('message', res.data.message);
				  }
    		})
    		.catch(err => Bus.$emit('error', err))
    	},
    	routerLink(params) {
        delCookie('moreScrollTop')
        setCookie('moreScrollTop', event.target.offsetTop - params.event.changedTouches[0].pageY + this.$refs.coursewareList.offsetTop, 60)
        this.$router.push({name: 'ResourceDetails', params: {id: params.id}})
      }
    }
  }
</script>

<style lang="less" scoped>
.wrapper {
  width: 100%;
  height: 100%;
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
.darkBg {
	height: 0.293333rem;
	background-color: #e8e8e8;
}
.moreRecommendBox {
	position: relative;
  height: 82%;
	overflow-y: scroll;
	-webkit-overflow-scrolling: touch; 
}
.moreRecommendList {
	padding: 0.266667rem 0.16rem 0;
}
.moreRecommendCtn {
	width: 9.68rem;
	height: 2.546667rem;
	margin-bottom: 0.213333rem;
	border-radius: 0.16rem;
	background-color: #ffffff;
}
.moreRecommendCtn .titleCtn {
	float: left;
	height: 1.333333rem;
}
.moreRecommendCtn a {
	display: block;
	height: 100%;
}
.moreRecommendCtn .titleImg {
	float: left;
	margin-top: 0.25rem;
	margin-left: 0.453333rem;
	width: 3.333333rem;
  height: 2.093333rem;
	position: relative;
}
.moreRecommendCtn .titleImg .crown {
  width: 0.586667rem;
  height: 0.546667rem;
  position: absolute;
  right: -0.3rem;
  top: -0.3rem;
}
.moreRecommendCtn .titleImg img {
	width: 3.333333rem;
  height: 2.093333rem;
}
.moreRecommendCtn p {
	width: 5.4rem;
	margin-top: 0.413333rem;
	margin-left: 0.36rem;
	color: #555555;
	overflow : hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-line-clamp:2;
	-webkit-box-orient: vertical;
}
.moreRecommendCtn .bottomLabel {
	float: left;
	width: 5.2rem;
	height: 0.4rem;
	margin-top: 0.36rem;
	margin-left: 0.36rem;
	color: #999999;
}
.moreRecommendCtn .bottomLabel .subjectLabel {
	float: left;
	padding: 0 0.16rem;
	border-radius: 0.4rem;
	border: 1px solid #2a51ed;
	color: #2a51ed;
}
.moreRecommendCtn .bottomLabel .timeLabel {
	float: right;
	margin-top: 0.133333rem;
}
</style>