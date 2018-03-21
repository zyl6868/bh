<template>
  <div>
    <div class="errBox" v-if="isErr">
      <div class="errShade">
        <p>{{msg}}</p>
        <div class="errBtn">
          <a href="javascript:;" @click="goBack">返回</a>
          <a href="javascript:;" @click="confirm">确定</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Bus from '../Bus/bus.js'
  export default {
    data() {
      return {
        isErr: false, // 是否有错误
        msg: '数据加载失败'
      }
    },
    created() {
      Bus.$on('error', (err) => {
        if(err !== '') {
          this.msg = '数据加载失败';
          this.isErr = true;
        }
      })
      Bus.$on('message', (msg) => {
        if(msg !== '') {
          this.msg = msg;
          this.isErr = true;
        }
      })
    },
    methods: {
      goBack() {
        this.isErr = false;
        this.$router.go(-1);
      },
      confirm() {
        this.isErr = false;
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
.errBox {
  height: 100%;
  width: 100%;
  background-color: rgba(255, 255, 255, 0.1);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 100;
}
.errShade {
  margin: 8.0rem auto 0;
  width: 70%;
  background-color: rgb(255, 255, 255);
  height: 3.0rem;
  border-radius: 0.533333rem;
}
.errShade p {
  font-size: 18px;
  height: 2.0rem;
  line-height: 2.0rem;
  text-align: center;
  color: #666;
  border-bottom: 1px solid #ece2c6;
}
.errShade a {
  display: block;
  float: left;
  width: 50%;
  color: #007ef9;
  font-size: 16px;
  line-height: 1.0rem;
  text-decoration: none;
  text-align: center;
}
.errShade a:first-child {
  border-right: 1px solid #ece2c6;
}
@media screen and (max-width) {
  .errShade p {
    font-size: 16px;
  }
  .errShade a {
    font-size: 14px;
  }
}
</style>