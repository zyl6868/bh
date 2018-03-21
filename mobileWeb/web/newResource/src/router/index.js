import Vue from 'vue'
import Router from 'vue-router'

// 课件教案
const Courseware = r => require.ensure([], () => r(require('@/components/Courseware/Courseware')), 'Courseware')
// 精品作业
const FineWork = r => require.ensure([], () => r(require('@/components/FineWork/FineWork')), 'FineWork')
// 资源详情
const ResourceDetails = r => require.ensure([], () => r(require('@/components/ResourceDetails/ResourceDetails')), 'ResourceDetails')
// 我的课件教案
const MyCourseware = r => require.ensure([], () => r(require('@/components/MyCourseware/MyCourseware')), 'MyCourseware')
// 更多推荐
const MoreRecommend = r => require.ensure([], () => r(require('@/components/MoreRecommend/MoreRecommend')), 'MoreRecommend')
// 投屏
const ShareScreen = r => require.ensure([], () => r(require('@/components/ResourceDetails/children/ShareScreen')), 'ShareScreen')

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/courseware', // 课件教案
      name: 'Courseware',
      component: Courseware,
      meta: {keepAlive: true}
    },
    {
      path: '/fineWork', // 精品作业
      name: 'FineWork',
      component: FineWork,
      meta: {keepAlive: false}
    },
    {
      path: '/resourceDetails/:id',  // 资源详情
      name: 'ResourceDetails',
      component: ResourceDetails,
      meta: {keepAlive: false}
    },
    {
      path: '/myCourseware', // 我的课件教案
      name: 'MyCourseware',
      component: MyCourseware,
      meta: {keepAlive: false}
    },
    {
      path: '/moreRecommend', // 更多推荐
      name: 'MoreRecommend',
      component: MoreRecommend,
      meta: {keepAlive: true}
    },
    {
      path: '/shareScreen/:id/:url', // 投屏
      name: 'ShareScreen',
      component: ShareScreen,
      meta: {keepAlive: false}
    }
  ]
})
