
const httpConfig = {
  ceshi: '/courseware?token={"uid":"202534","token":"c537c8af-ccc7-4f46-9751-bfeec4f3b969"}&vp=courseware', // ceshi
  csChapterDefault: '/courseware/chapter/get-user-default', // 获取默认版本信息
  csMaterialList: '/courseware/material-list', // 获取课件教案列表
  csMaterialDetail: '/courseware/material/detail?file-id=', // 资源详情
  csMaterialPreview: '/courseware/material/preview?file-id=', // 资源详情预览
  csMaterialDownload: '/courseware/material/download', // 资源详情下载
  csMaterialCollect: '/courseware/material-collect?page=', // 课件教案个人收藏列表
  csMaterialCancleCollect: '/courseware/material/cancle-collect', // 取消收藏
  csMaterialRecommend: '/courseware/material-recommend?page=', // 推荐资源列表
  csChapter: '/courseware/chapter', // 获取章节列表
  csMaterial_collect: '/courseware/material/collect', // 课件教案收藏
  csChapterVersion: '/courseware/chapter/version', // 获取学段学科下的版本
  csChapterTome: '/courseware/chapter/tome', // 获取学段学科下版本的分册
  csChapterSaveUserDefault: '/courseware/chapter/save-user-default', // 保存默认选项
  csMaterialIsCollected: '/courseware/material/is-collected?file-ids=', // 是否已收藏
  hwList: '/homework/homework-list', // 精品作业列表
  csMaterialShow: '/courseware/material/show?file-id=', // 投屏
  siteLogin: '/site/login?token=', // 登录
  csUserLevel: '/courseware/user/user-level', // 用户等级
}

export default httpConfig
