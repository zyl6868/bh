<template>
  <div id="app">
    <keep-alive>
      <router-view
        transition="fade"
        transition-mode="out-in"
        v-if="$route.meta.keepAlive"
      ></router-view>
    </keep-alive>
    <router-view
      transition="fade"
      transition-mode="out-in"
      v-if="!$route.meta.keepAlive"
    ></router-view>
    <err></err>
  </div>
</template>

<script>
import err from './components/Global/404/404.vue'
export default {
  name: 'app',
  components: {
  	err,
  },
}
</script>

<style lang="less">
@import './style/base.css';
@import './style/select.css';
</style>
