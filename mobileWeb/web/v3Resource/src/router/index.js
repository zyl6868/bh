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
// 搜索全部
const SearchAll = r => require.ensure([], () => r(require('@/components/Search/SearchAll')), 'SearchAll')
// 搜索课件教案
const SearchCourseware = r => require.ensure([], () => r(require('@/components/Search/Children/SearchCourseware')), 'SearchCourseware')
// 搜索精品作业
const SearchFineWork = r => require.ensure([], () => r(require('@/components/Search/Children/SearchFineWork')), 'SearchFineWork')

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/courseware', // 课件教案
      name: 'Courseware',
      component: Courseware,
      meta: {title: '课件教案', keepAlive: true}
    },
    {
      path: '/fineWork', // 精品作业
      name: 'FineWork',
      component: FineWork,
      meta: {title: '精品作业', keepAlive: false}
    },
    {
      path: '/resourceDetails/:id',  // 资源详情
      name: 'ResourceDetails',
      component: ResourceDetails,
      meta: {title: '资源详情', keepAlive: false}
    },
    {
      path: '/myCourseware', // 我的课件教案
      name: 'MyCourseware',
      component: MyCourseware,
      meta: {title: '课件教案', keepAlive: false}
    },
    {
      path: '/moreRecommend', // 更多推荐
      name: 'MoreRecommend',
      component: MoreRecommend,
      meta: {title: '更多推荐', keepAlive: true}
    },
    {
      path: '/shareScreen/:id/:url', // 投屏
      name: 'ShareScreen',
      component: ShareScreen,
      meta: {title: '投屏', keepAlive: false}
    },
    {
      path: '/searchAll/:keyword', // 搜索全部
      name: 'SearchAll',
      component: SearchAll,
      meta: {title: '搜索', keepAlive: true}
    },
    {
      path: '/searchCourseware/:keyword', // 搜索课件教案
      name: 'SearchCourseware',
      component: SearchCourseware,
      meta: {title: '搜索课件教案', keepAlive: true}
    },
    {
      path: '/searchFineWork/:keyword', // 搜索精品作业
      name: 'SearchFineWork',
      component: SearchFineWork,
      meta: {title: '搜索精品作业', keepAlive: false}
    }
  ]
})
