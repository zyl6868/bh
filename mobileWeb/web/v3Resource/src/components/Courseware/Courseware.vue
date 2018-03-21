<template>
  <div class="wrapper">
    <div class="selectPackage" ref="selectPackage">
      <div class="selectTool">
        <div class="titleSelect" @click="openShade">
          <span class="departmentSubject">{{departmentSubject.department}}{{departmentSubject.subject}}</span>&nbsp;
          <span class="subjectVersion">{{subjectVersion.versionName}}</span>&nbsp;
          <span class="VersionVolume">{{VersionVolumeList.name}}</span>
          <i class="iconfont">&#xe632;</i>
        </div>
        <div class="twoSelect">
          <div class="chapterSelect two_select" @click="toggleChapterOrResource(0)">
            <p :class="{selected: twoSelect[0].isSelect}">{{twoSelect[0].title}}</p><i class="iconfont" v-html="twoSelect[0].upOrDown" :class="{selected: twoSelect[0].isSelect}"></i>
              <div class="chapterBox" v-show="twoSelect[0].isSelect">
                <ul>
                  <li class="allChapter" @click="allChapter">全部章节</li>
                  <li v-for="(items, index) in chapter">
                    <div class="unitTitle" @click="chapterSelect(items.chapterId, items.chapterName)">{{items.chapterName}}</div>
                    <ul>
                      <li v-for="(lists, flag) in items.list" @click="chapterSelect(lists.chapterId, lists.chapterName)">{{lists.chapterName}}</li>
                    </ul>
                  </li>
                </ul>
              </div>
          </div>
          <div class="resourceSelect two_select" @click="toggleChapterOrResource(1)">
            <p :class="{selected: twoSelect[1].isSelect}">{{twoSelect[1].title}}</p><i class="iconfont" v-html="twoSelect[1].upOrDown" :class="{selected: twoSelect[1].isSelect}"></i>
            <div class="resourceBox" v-show="twoSelect[1].isSelect">
              <ul>
                <li v-for="(lists, index) in resourceLi" @click="resourceSelect(index)">{{lists.resourceName}}</li>
              </ul>
            </div>
          </div>
          <div class="centerLine"></div>
        </div>
      </div>
      <div class="selectTeaching" v-show="isSelectTeaching">
        <div class="selectBox">
          <p>选择教材</p>
          <div class="selectSubject">
            <p @click="selectSubject">{{selectDepartmentSubject.department}}{{selectDepartmentSubject.subject}}<i class="iconfont" v-html="subjectUpOrDown"></i></p>
            <div class="subjectList " v-show="isSelectSubject">
              <div v-for="(subjects, index) in subjectList">
                <p v-for="(list, flag) in subjects.list" @click="toggleSubject(subjects.departmentId, list.subjectId, subjects.department, list.subject, index, flag)" :class="{blue :list.isSelect}">{{subjects.department}}{{list.subject}}</p>
              </div>
            </div>
          </div>
          <!--  -->
          <div class="versionList" v-show="selectDepartmentSubject.department != '请选择学科'">
            <div class="version" v-for="(subjectVersions, index) in selectSubjectVersionList" :to="index">
              <p @click="selectSubjectVersion(index)">{{subjectVersions.versionName}}<i class="iconfont" v-html="subjectVersions.upOrDown"></i></p>
              <div class="Xscroll" v-show="subjectVersions.isSelectVersion">
                <ul v-show="subjectVersions.subjectVersionVolumeList.length > 0">
                  <li v-for="(subjectVersionVolumes, flag) in subjectVersions.subjectVersionVolumeList" @click="selectSubjectVersionVolume(index, flag)">
                    <div class="VolumeImg">
                      <img src="../../images/noImage.png" v-show="subjectVersionVolumes.image == ''">
                      <img :src="subjectVersionVolumes.image" v-show="subjectVersionVolumes.image != ''" @error.once="noFindVolumesImg()">
                      <div class="bookshade" v-show="subjectVersionVolumes.isSelect">
                        <i class="iconfont">&#xe60a;</i>
                      </div>
                    </div>
                    <p>{{subjectVersionVolumes.name}}</p>
                  </li>
                </ul>
                <div v-show="subjectVersions.subjectVersionVolumeList == ''" class="loadingGif">
                  <img src="../../images/loading.gif">
                </div>
              </div>
            </div>
          </div>
          <div class="confirmBtn" @click="confirmHandle" v-show="canConfirm">确定</div>
          <div class="closeBtn" @click="closeShade">
            <i class="iconfont close">&#xe676;</i>
          </div>
        </div>
      </div>
    </div>
    <div class="coursewareBox" v-show="coursewareLists.length > 0" ref="coursewareList">
      <mt-loadmore :bottom-method="loadBottom" :bottom-all-loaded="allLoaded" ref="loadmore" @bottom-status-change="handleBottomChange" :auto-fill="isAutoFill">
        <ul class="coursewareList">
          <li class="coursewareCtn" v-for="list in coursewareLists" ref="list" v-tap="{methods: routerLink, listId: list.id}">
            <div class="titleImg">
              <img :src="list.image" @error.once="noFindListImg()" v-show="list.image != null">
              <img src="../../images/listDefault.jpg" v-show="list.image == null">
              <span v-show="list.isBoutique == 1"></span>
            </div>
            <div class="titleCtn">
              <p>{{list.name}}</p>
            </div>
            <div class="getBtn">
              <div class="downloadBtn"><i class="iconfont">&#xe615;</i>&nbsp;<span class="downloadNum">{{list.downNum}}</span><i class="iconfont" :class="{blue: list.isCollected}">&#xe501;</i>&nbsp;<span class="downloadNum" :class="{blue: list.isCollected}">{{list.favoriteNum}}</span></div>
            </div>
          </li>
        </ul>
      </mt-loadmore>
    </div>
    <noList v-show="coursewareLists.length == 0" :info="info"></noList>
  </div>
</template>
<script>
import Bus from '../Global/Bus/bus.js'
import noList from '../Global/NoList/NoList.vue'
import { Toast } from 'mint-ui'
import isLogin from '../../util/isLogin.js'
import { getCookie, setCookie, delCookie } from '../../util/cookie.js'
export default {
  data() {
    return {
      info: '',
      coursewareLists: [], // 课件列表
      pageIndex: 2, // 页码
      pageCount: 0, // 总页数
      allLoaded: false, // 允许再次调用上拉函数
      isAutoFill: false, // 是否自动触发下拉函数填充满父盒子
      chapter: [],  // 全部章节列表
      resourceLi: [{  // 资源列表
        resourceName: '全部资源',
        matType: 1
      }, {
        resourceName: '课件资源',
        matType: 2
      }, {
        resourceName: '教案资源',
        matType: 3
      }],
      twoSelect: [{  // 章节和资源导航
        title: '全部章节',
        upOrDown: '&#xe632',
        isSelect: false,
        id: 0
      }, {
        title: '全部资源',
        upOrDown: '&#xe632',
        isSelect: false,
        id: 1
      }],
      subjectList: [{ // 学段，学科列表(写死的信息)
        department: '小学部',
        departmentId: 20201,
        list: [{
          subject: '语文',
          subjectId: 10010,
          isSelect: false
        }, {
          subject: '数学',
          subjectId: 10011,
          isSelect: false
        }, {
          subject: '英语',
          subjectId: 10012,
          isSelect: false
        }]
      }, {
        department: '初中部',
        departmentId: 20202,
        list: [{
          subject: '语文',
          subjectId: 10010,
          isSelect: false
        }, {
          subject: '数学',
          subjectId: 10011,
          isSelect: false
        }, {
          subject: '英语',
          subjectId: 10012,
          isSelect: false
        }, {
          subject: '生物',
          subjectId: 10013,
          isSelect: false
        }, {
          subject: '物理',
          subjectId: 10014,
          isSelect: false
        }, {
          subject: '化学',
          subjectId: 10015,
          isSelect: false
        }, {
          subject: '地理',
          subjectId: 10016,
          isSelect: false
        }, {
          subject: '历史',
          subjectId: 10017,
          isSelect: false
        }, {
          subject: '思想品德',
          subjectId: 10029,
          isSelect: false
        }]
      }, {
        department: '高中部',
        departmentId: 20203,
        list: [{
          subject: '语文',
          subjectId: 10010,
          isSelect: false
        }, {
          subject: '数学',
          subjectId: 10011,
          isSelect: false
        }, {
          subject: '英语',
          subjectId: 10012,
          isSelect: false
        }, {
          subject: '生物',
          subjectId: 10013,
          isSelect: false
        }, {
          subject: '物理',
          subjectId: 10014,
          isSelect: false
        }, {
          subject: '化学',
          subjectId: 10015,
          isSelect: false
        }, {
          subject: '地理',
          subjectId: 10016,
          isSelect: false
        }, {
          subject: '历史',
          subjectId: 10017,
          isSelect: false
        }, {
          subject: '政治',
          subjectId: 10018,
          isSelect: false
        }]
      }],
      subjectVersionList: [], // 学科版本列表
      selectSubjectVersionList: [], // 弹框中的学科版本列表
      isSelectTeaching: false, // 选择教材弹框 默认不打开
      departmentSubject: { // 选择的学段学科
        department: '请选择',
        subject: '',
        departmentId: 0,
        subjectId: 0
      },
      selectDepartmentSubject: { // 在弹框中选择的学科
        department: '请选择学科',
        subject: '',
        departmentId: 0,
        subjectId: 0
      },
      isSelectSubject: false, // 选择学段学科，true下拉，false回显
      subjectUpOrDown: '&#xe632', // 选择学段学科 默认是下箭头
      subjectVersion: { versionId: 0, versionName: '' }, // 选择的学科版本
      SelectSubjectVersion: { versionId: 0, versionName: '' }, // 在弹框中选择的学科版本
      VersionVolumeList: { id: 0, name: '' }, // 选择的版本分册信息
      SelectVersionVolumeList: { id: 0, name: '' }, // 在弹框中选择的版本分册信息
      isDefault: true, // 是否有默认
      canConfirm: true, // 是否可以确认
    }
  },
  components: {
    noList
  },
  beforeRouteEnter(to, from, next) {
    if(from.name == 'ResourceDetails') {
      next(vm => {

        vm.$refs.coursewareList.scrollTop = getCookie('scrollTop');
      })
    } else {
      next()
    }
    
  },
  created() {
    
    // this.$axios.get(this.$httpConfig.ceshi)
    
    if (!isLogin) {
      // 是否默认状态为否
      this.isDefault = false;
      // 是否可以确认状态为否
      this.canConfirm = false;
      // 如果没有默认信息 弹框选择
      this.openShade();
      // 默认展开选择
      this.selectSubject();
    } else {
    // 请求获取默认版本信息
    this.$axios.get(this.$httpConfig.csChapterDefault)
      .then(res => {
        let data = res.data;
        if (res.status == 200) {
          if (data == '') {
            // 是否默认状态为否
            this.isDefault = false;
            // 是否可以确认状态为否
            this.canConfirm = false;
            // 如果没有默认信息 弹框选择
            this.openShade();
            // 默认展开选择
            this.selectSubject();
          } else {
            // 初始化数据
            // 初始化学段学科
            this.departmentSubject.department = data.departmentName;
            this.departmentSubject.departmentId = data.department;
            this.departmentSubject.subject = data.subjectName;
            this.departmentSubject.subjectId = data.subjectId;
            // 将默认的学段学科拷贝给弹框中的学段学科
            this.selectDepartmentSubject = this.shallowCopy(this.departmentSubject);

            // 初始化学科版本
            this.subjectVersion.versionName = data.versionName;
            this.subjectVersion.versionId = data.version;
            // 将默认的学科版本拷贝给弹框中的学科版本
            this.SelectSubjectVersion = this.shallowCopy(this.subjectVersion);

            // 初始化版本分册信息
            this.VersionVolumeList.name = data.tomeName;
            this.VersionVolumeList.id = data.tome;

            // 将默认的版本分册拷贝给弹框中的版本分册
            this.SelectVersionVolumeList = this.shallowCopy(this.VersionVolumeList);

            // 将全部章节中的id 换为分册id
            this.twoSelect[0].id = this.VersionVolumeList.id;

            // 请求课件教案列表
            this.materialList();

            // 请求章节列表
            this.getChapterList();
            
          }
        } else {
          Bus.$emit('message', res.data.message);
        }
      })
      .catch(err => Bus.$emit('error', err))
    }
  },
  mounted() {
    this.$refs.coursewareList.style.height = (document.body.clientHeight - this.$refs.selectPackage.offsetHeight - 20) + 'px';
  },
  methods: {
    noFindVolumesImg() {  // 分册没有图片
      event.target.src = '/static/noImage.png'
    },
    noFindListImg() {  // 列表图片加载失败
      event.target.src = '/static/listDefault.jpg'
    },
    selectSubject() { // 选择学段 学科
      this.isSelectSubject = !this.isSelectSubject;
      if (this.isSelectSubject) {
        this.subjectUpOrDown = '&#xe604';
      } else {
        this.subjectUpOrDown = '&#xe632';
      }
    },
    openShade() {
      // 初始化两个导航全部收起
      this.initToggleChapterOrResource();
      this.isSelectTeaching = !this.isSelectTeaching;
      // 如果没有默认
      if (!this.isDefault) {
        this.selectDepartmentSubject.department = '请选择学科';
      } else {
        if (!this.isShade) {
          // 获取学科下的版本
            this.$axios.get(this.$httpConfig.csChapterVersion, {
              params: {
                'department-id': this.selectDepartmentSubject.departmentId,
                'subject-id': this.selectDepartmentSubject.subjectId
              }
            })
              .then(res => {
                if (res.status == 200) {
                  // 存储学科版本列表
                  this.selectSubjectVersionList = res.data;
                  // 初始化分册下拉(学科版本列表中添加字段)
                  this.selectSubjectVersionList.forEach((ele) => {
                    this.$set(ele, 'isSelectVersion', false);
                    this.$set(ele, 'upOrDown', '&#xe632');
                    this.$set(ele, 'subjectVersionVolumeList', []);
                  });
                  // 将学科列表 拷贝给 弹窗中的学科列表
                  this.subjectVersionList = this.shallowCopy(this.selectSubjectVersionList)

                  // 默认选中
                  this.selectSubjectVersionList.forEach((ele, index) => {
                    if (ele.versionId == this.SelectSubjectVersion.versionId) {
                      // 把在弹框中选择的版本存在SelectSubjectVersion 对象中
                      this.SelectSubjectVersion.versionId = this.selectSubjectVersionList[index].versionId;
                      this.SelectSubjectVersion.versionName = this.selectSubjectVersionList[index].versionName;

                      // 判断本条下有没有分册信息 (如果没有，请求数据)
                      if (this.selectSubjectVersionList[index].subjectVersionVolumeList.length == 0) {
                        // 请求版本下分册信息
                        this.$axios.get(this.$httpConfig.csChapterTome, {
                          params: {
                            'department-id': this.selectDepartmentSubject.departmentId,
                            'subject-id': this.selectDepartmentSubject.subjectId,
                            'version-id': this.SelectSubjectVersion.versionId
                          }
                        })
                          .then(res => {
                            if (res.status == 200) {
                              // 在版本信息中添加是否选中标识
                              res.data.forEach(ele => {
                                ele.isSelect = false;
                              });
                              // 将版本信息下的分册信息添加到本条版本信息中
                              this.selectSubjectVersionList[index].subjectVersionVolumeList = res.data;
                              this.selectSubjectVersionList[index].subjectVersionVolumeList.forEach((element, flag) => {
                                if (this.SelectVersionVolumeList.id == element.id) {
                                  // 选中分册
                                  this.selectSubjectVersionVolume(index, flag);
                                  // 同步信息
                                  this.subjectVersionList = this.shallowCopy(this.selectSubjectVersionList);

                                }
                              })
                            } else {
                              Bus.$emit('message', res.data.message);
                            }
                          })
                          .catch(err => Bus.$emit('error', err))
                      }

                      // 切换学科版本
                      if (this.selectSubjectVersionList[index].isSelectVersion) {
                        this.initVersionUpOrDown();
                        this.selectSubjectVersionList[index].isSelectVersion = false;
                        this.selectSubjectVersionList[index].upOrDown = '&#xe632';
                      } else {
                        this.initVersionUpOrDown();
                        this.selectSubjectVersionList[index].isSelectVersion = true;
                        this.selectSubjectVersionList[index].upOrDown = '&#xe604';
                      }
                    }
                  })
                  
                  
                } else {
                  Bus.$emit('message', res.data.message);
                }
              })
              .catch(err => Bus.$emit('error', err))
          
          
          this.isShade = true
        }
      }
    },
    closeShade() { // 选择教材关闭弹框
      if(this.isDefault) {
        this.canConfirm = true;
        // 用当前信息替换掉 弹框信息
        this.selectDepartmentSubject = this.shallowCopy(this.departmentSubject);
        this.SelectSubjectVersion = this.shallowCopy(this.subjectVersion);
        this.SelectVersionVolumeList = this.shallowCopy(this.VersionVolumeList);
        this.selectSubjectVersionList = this.shallowCopy(this.subjectVersionList);

        // 关闭弹框
        this.isSelectTeaching = !this.isSelectTeaching;
      } else {
        // 返回上一页
        BHWEB.pop();
      }
    },
    confirmHandle() { // 弹框确认
      // 有默认
      this.isDefault = true;
      // 如果选择的所有信息都和当前相同，不发送请求，用当前信息覆盖弹窗信息
      if (this.VersionVolumeList.id == this.SelectVersionVolumeList.id || this.SelectVersionVolumeList.id == 0) {
        // 用当前的信息，覆盖掉弹框信息
        this.selectDepartmentSubject = this.shallowCopy(this.departmentSubject);
        this.SelectSubjectVersion = this.shallowCopy(this.subjectVersion);
        this.SelectVersionVolumeList = this.shallowCopy(this.VersionVolumeList);
        this.selectSubjectVersionList = this.shallowCopy(this.subjectVersionList);
        // 关闭弹框
        this.isSelectTeaching = !this.isSelectTeaching;
      } else { // 如果不相同
        // 用弹窗中的信息替换掉，当前信息
        this.departmentSubject = this.shallowCopy(this.selectDepartmentSubject);
        this.subjectVersion = this.shallowCopy(this.SelectSubjectVersion);
        this.VersionVolumeList = this.shallowCopy(this.SelectVersionVolumeList);
        this.subjectVersionList = this.shallowCopy(this.selectSubjectVersionList);
        // 请求更改默认
        if (!isLogin) {
          // 收起弹框
          this.isSelectTeaching = !this.isSelectTeaching;
          // 将章节中的 替换为全部章节的信息
          this.twoSelect[0].title = '全部章节';
          this.twoSelect[0].id = this.VersionVolumeList.id;
          // 将资源中的 替换为全部资源的信息
          this.twoSelect[1].title = '全部资源';
          this.twoSelect[1].id = 1;

          // 请求课件教案列表
          this.materialList();

          // 请求章节列表
          this.getChapterList();
        } else {
          this.$axios.post(this.$httpConfig.csChapterSaveUserDefault, {
            'department-id': this.selectDepartmentSubject.departmentId,
            'subject-id': this.selectDepartmentSubject.subjectId,
            'version-id': this.SelectSubjectVersion.versionId,
            'tome-id': this.SelectVersionVolumeList.id
          })
            .then(res => {
              if (res.status == 200) {
                // 收起弹框
                this.isSelectTeaching = !this.isSelectTeaching;
                // 将章节中的 替换为全部章节的信息
                this.twoSelect[0].title = '全部章节';
                this.twoSelect[0].id = this.VersionVolumeList.id;
                // 将资源中的 替换为全部资源的信息
                this.twoSelect[1].title = '全部资源';
                this.twoSelect[1].id = 1;

                // 请求课件教案列表
                this.materialList();

                // 请求章节列表
                this.getChapterList();
                
              } else {
                Bus.$emit('message', res.data.message);
              }
            })
            .catch(err => Bus.$emit('error', err))
        }
        
      }
    },
    initSubject() {    // 初始化，学段学科列表
      this.subjectList.forEach(element => {
        element.list.forEach(ele => {
          ele.isSelect = false
        })
      })
    },
    toggleSubject(departmentId, subjectId, department, subject, index, flag) {  // 切换学科
      // 已更换学科 不可以确认
      this.canConfirm = false;

      // 当前学段学科为 选择的学段名+学科名
      this.selectDepartmentSubject.department = department;
      this.selectDepartmentSubject.subject = subject;
      this.selectDepartmentSubject.departmentId = departmentId;
      this.selectDepartmentSubject.subjectId = subjectId;

      // 初始化，学段学科列表
      this.initSubject();
      // 当前学段学科列表被选中
      this.subjectList[index].list[flag].isSelect = true;

      // 初始化在弹框中选择的学科版本
      this.SelectSubjectVersion.versionId = 0;
      this.SelectSubjectVersion.versionName = '';
      // 初始化在弹框中选择的版本分册信息
      this.SelectVersionVolumeList.id = 0;
      this.SelectVersionVolumeList.name = '';
      
      // 收缩选择学段学科列表
      this.selectSubject();
      if (this.isDefault) {
        // 弹窗中获取学段学科下的版本
        this.getSubjectVersion();
      } else {
        // 获取弹框中的版本
        this.selectSubjectVersionList = [];
        this.$axios.get(this.$httpConfig.csChapterVersion, {
          params: {
            "department-id": this.selectDepartmentSubject.departmentId,
            "subject-id": this.selectDepartmentSubject.subjectId
          }
        })
          .then(res => {
            if (res.status == 200) {
              // 存储学科版本列表
              this.selectSubjectVersionList = res.data;
              // 初始化分册下拉(学科版本列表中添加字段)
              this.selectSubjectVersionList.forEach((ele) => {
                this.$set(ele, 'isSelectVersion', false);
                this.$set(ele, 'upOrDown', '&#xe632');
                this.$set(ele, 'subjectVersionVolumeList', []);
              });
              // 默认展开第一个
              this.selectSubjectVersion(0)
            } else {
              Bus.$emit('message', res.data.message);
            }
          })
          .catch(err => Bus.$emit('error', err))
      }
      
    },
    initVersionUpOrDown() { // 初始化分册下拉(学科版本列表中添加字段)
      this.selectSubjectVersionList.forEach((ele) => {
        this.$set(ele, 'isSelectVersion', false);
        this.$set(ele, 'upOrDown', '&#xe632');
      });
    },
    initVersionVolumeListSelect() { // 初始化分册信息中是否选中字段为false
      for (var i = 0; i < this.selectSubjectVersionList.length; i++) {
        for (var j = 0; j < this.selectSubjectVersionList[i].subjectVersionVolumeList.length; j++) {
          this.selectSubjectVersionList[i].subjectVersionVolumeList[j].isSelect = false;
        }
      }
    },
    initToggleChapterOrResource() { // 初始化章节或者资源导航下拉
      this.twoSelect.forEach(ele => {
        ele.isSelect = false;
        ele.upOrDown = '&#xe632';
      })
    },
    selectSubjectVersion(index) { // 选择学科版本(人教版、冀教版)
      // 把在弹框中选择的版本存在SelectSubjectVersion 对象中  ？？？？？？？？？？？？？
      // this.SelectSubjectVersion.versionId = this.selectSubjectVersionList[index].versionId;
      // this.SelectSubjectVersion.versionName = this.selectSubjectVersionList[index].versionName;

      // 判断本条下有没有分册信息 (如果没有，请求数据)
      if (this.selectSubjectVersionList[index].subjectVersionVolumeList.length == 0) {
        // 请求版本下分册信息
        this.getsubjectVersionVolume(index);
      }

      // 切换学科版本
      if (this.selectSubjectVersionList[index].isSelectVersion) {
        this.initVersionUpOrDown();
        this.selectSubjectVersionList[index].isSelectVersion = false;
        this.selectSubjectVersionList[index].upOrDown = '&#xe632';
      } else {
        this.initVersionUpOrDown();
        this.selectSubjectVersionList[index].isSelectVersion = true;
        this.selectSubjectVersionList[index].upOrDown = '&#xe604';
      }
    },
    selectSubjectVersionVolume(index, flag) { // 选择学科版本下的分册信息(一年级上，下)
      this.SelectVersionVolumeList.id = 0;
      this.SelectVersionVolumeList.name = '';

      // 切换学科版本分册信息
      if (this.selectSubjectVersionList[index].subjectVersionVolumeList[flag].isSelect) { // 如果当前被选中
        this.canConfirm = false;

        // 初始化分册信息中全部未选中
        this.initVersionVolumeListSelect();
        this.selectSubjectVersionList[index].subjectVersionVolumeList[flag].isSelect = false;
      } else { // 如果没有被选中
        this.canConfirm = true;

        // 把在弹框中选择的版本存在SelectSubjectVersion 对象中  ？？？？？？？？？？？？？
        this.SelectSubjectVersion.versionId = this.selectSubjectVersionList[index].versionId;
        this.SelectSubjectVersion.versionName = this.selectSubjectVersionList[index].versionName;

        // 把在弹框中选择的版本分册信息存在SelectVersionVolumeList 对象中
        this.SelectVersionVolumeList.id = this.selectSubjectVersionList[index].subjectVersionVolumeList[flag].id;
        this.SelectVersionVolumeList.name = this.selectSubjectVersionList[index].subjectVersionVolumeList[flag].name;
        
        this.initVersionVolumeListSelect();
        this.selectSubjectVersionList[index].subjectVersionVolumeList[flag].isSelect = true;
      }
      // 深拷贝 触发vue视图更新
      this.selectSubjectVersionList = JSON.parse(JSON.stringify(this.selectSubjectVersionList));
    },
    shallowCopy(src) { // 浅拷贝
      // var dst = {};
      // for (var prop in src) {
      //   if (src.hasOwnProperty(prop)) {
      //     dst[prop] = src[prop];
      //   }
      // }
      // return dst;
      return JSON.parse(JSON.stringify(src))
    },
    toggleChapterOrResource(index) { // 切换中午导航(章节或者资源)
      if (this.twoSelect[index].isSelect) {
        this.initToggleChapterOrResource();
        this.twoSelect[index].isSelect = false;
        this.twoSelect[index].upOrDown = '&#xe632';
      } else {
        this.initToggleChapterOrResource();
        this.twoSelect[index].isSelect = true;
        this.twoSelect[index].upOrDown = '&#xe604';
      }
    },
    chapterSelect(id, name) { // 选择章节
      this.twoSelect[0].title = name;
      this.twoSelect[0].id = id;
      this.materialList();
    },
    allChapter() { // 选择全部章节
      this.twoSelect[0].title = '全部章节';
      
      // 将全部章节中的id 换为分册id
      this.twoSelect[0].id = this.VersionVolumeList.id;
      // 请求课件教案列表
      this.materialList();
    },
    resourceSelect(index) { // 选择资源类型
      this.twoSelect[1].title = this.resourceLi[index].resourceName;
      // 把全部资源中的id 换为选中的资源id 
      this.twoSelect[1].id = this.resourceLi[index].matType;
      // 请求课件教案列表
      this.materialList();
    },
    loadBottom() { // 上拉加载更多操作
      // 通知组件的状态改变，下拉完成(初始设置)
      this.$refs.loadmore.onBottomLoaded();
      if (this.pageIndex > this.pageCount ) {
        Toast({
          message: '已经到底了',
          position: 'bottom',
          duration: 1000
        })
        this.allLoaded = true;
      } else {  
        this.$axios.get(this.$httpConfig.csMaterialList, {
          params: {
            'department-id': this.departmentSubject.departmentId,
            'subject-id': this.departmentSubject.subjectId,
            'version-id': this.subjectVersion.versionId,
            'chapter-id': this.twoSelect[0].id,
            'mat-type': this.twoSelect[1].id,
            'page': this.pageIndex++
          }
        })
          .then(res => {
            if (res.status == 200) {
              if (this.pageIndex > this.pageCount) {
                Toast({
                  message: '已经到底了',
                  position: 'bottom',
                  duration: 1000
                })
                this.allLoaded = true;
              }
              var lists = res.data.items;
              let str = '';
              res.data.items.forEach(ele => {
                str += ele.id + ',';
              })
              str = str.substring(0, str.length-1)
              if (isLogin) {
                this.$axios.get(this.$httpConfig.csMaterialIsCollected + str)
                .then(res => {
                  if (res.status == 200) {
                    lists.forEach(ele => {
                      this.$set(ele, 'isCollected', false)
                      for(var i = 0; i < res.data.length; i++) {
                        if (ele.id == res.data[i]){
                          ele.isCollected = true;
                          return;
                        }
                      }
                    })
                    this.coursewareLists = this.coursewareLists.concat(lists);
                  } else {
                    Bus.$emit('message', res.data.message);
                  }
                })
                .catch(err => Bus.$emit('error', err))
              } else {
                lists.forEach(ele => {
                  this.$set(ele, 'isCollected', false)
                })
                this.coursewareLists = this.coursewareLists.concat(lists);
              }
            } else {
              Bus.$emit('message', res.data.message);
            }
          })
          .catch(err => Bus.$emit('error', err))
      }

    },
    handleBottomChange(s) { // 下拉改变
      // console.log(s);
    },
    materialList() { // 请求课件教案列表(传章节Id，切换时用)
      // 是否可上拉 初始化
      this.allLoaded = false;
      // 默认章节数 2 初始化
      this.pageIndex = 2;
      // 课件列表滞空
      this.coursewareLists = [];
      this.info = '';
      this.$axios.get(this.$httpConfig.csMaterialList, {
          params: {
            'department-id': this.departmentSubject.departmentId,
            'subject-id': this.departmentSubject.subjectId,
            'version-id': this.subjectVersion.versionId,
            'chapter-id': this.twoSelect[0].id,
            'mat-type': this.twoSelect[1].id,
            'page': 1
          }
        })
        .then(res => {
          if (res.status == 200) {
            this.pageCount = res.data['_meta'].pageCount;
            if (this.pageIndex > this.pageCount) {
              this.allLoaded = true;
            }
            this.coursewareLists = res.data.items;
            if(res.data.items.length == 0) {
              this.info = '更换章节试试吧';
            }
            let str = '';
            res.data.items.forEach(ele => {
              str += ele.id + ',';
            })
            str = str.substring(0, str.length-1)
            if (res.data.items.length > 0 && isLogin) {
              if (isLogin) {
                this.$axios.get(this.$httpConfig.csMaterialIsCollected + str)
                  .then(res => {
                    if (res.status == 200) {
                      this.coursewareLists.forEach(ele => {
                        this.$set(ele, 'isCollected', false)
                        for(var i = 0; i < res.data.length; i++) {
                          if (ele.id == res.data[i]){
                            ele.isCollected = true;
                            return;
                          }
                        }
                      })
                    } else {
                      Bus.$emit('message', res.data.message);
                    }
                  })
                  .catch(err => Bus.$emit('error', err))
              } else {
                this.coursewareLists.forEach(ele => {
                  this.$set(ele, 'isCollected', false)
                })
              }
            }
          } else {
            Bus.$emit('message', res.data.message);
          }
        })
        .catch(err => Bus.$emit('error', err))
    },
    getChapterList() {      // 章节列表
      this.$axios.get(this.$httpConfig.csChapter, {
        params: {
          'department-id': this.departmentSubject.departmentId,
          'subject-id': this.departmentSubject.subjectId,
          'version-id': this.subjectVersion.versionId,
          'tome-id': this.VersionVolumeList.id
        }
      })
        .then(res => {
          if (res.status == 200) {
            this.chapter = res.data;
          } else {
            Bus.$emit('message', res.data.message);
          }
        })
        .catch(err => Bus.$emit('error', err))
    },
    getSubjectVersion() {   // 弹窗中获取学段学科下的版本
      this.selectSubjectVersionList = [];
      this.$axios.get(this.$httpConfig.csChapterVersion, {
        params: {
          "department-id": this.selectDepartmentSubject.departmentId,
          "subject-id": this.selectDepartmentSubject.subjectId
        }
      })
        .then(res => {
          if (res.status == 200) {
            // this.selectSubjectVersionList = [];
            // 存储学科版本列表
            this.selectSubjectVersionList = res.data;
            // 初始化分册下拉(学科版本列表中添加字段)
            this.selectSubjectVersionList.forEach((ele) => {
              this.$set(ele, 'isSelectVersion', false);
              this.$set(ele, 'upOrDown', '&#xe632');
              this.$set(ele, 'subjectVersionVolumeList', []);
            });
          } else {
            Bus.$emit('message', res.data.message);
          }
        })
        .catch(err => Bus.$emit('error', err))
    },
    getsubjectVersionVolume(index) {  // 获取学科下版本下分册
      this.$axios.get(this.$httpConfig.csChapterTome, {
        params: {
          'department-id': this.selectDepartmentSubject.departmentId,
          'subject-id': this.selectDepartmentSubject.subjectId,
          'version-id': this.selectSubjectVersionList[index].versionId
        }
      })
        .then(res => {
          if (res.status == 200) {
            // 在版本信息中添加是否选中标识
            res.data.forEach(ele => {
              ele.isSelect = false;
            });
            // 将版本信息下的分册信息添加到本条版本信息中
            this.selectSubjectVersionList[index].subjectVersionVolumeList = res.data;
          } else {
            Bus.$emit('message', res.data.message);
          }
        })
        .catch(err => Bus.$emit('error', err))
    },
    routerLink(params) {
      delCookie('scrollTop')
      setCookie('scrollTop', event.target.offsetTop - params.event.changedTouches[0].pageY + this.$refs.coursewareList.offsetTop, 60)
      this.$router.push({name: 'ResourceDetails', params: {id: params.listId}})
    }

  }
}

</script>
<style lang="less" scoped>
/* 课件教案列表 */
* {
  -webkit-user-select: none; /*不允许用户选中文字*/
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.wrapper {
  height: 100%;
  overflow: hidden;
}

.coursewareBox {
  height: 76%;
  overflow-y: scroll;
  -webkit-overflow-scrolling: touch;
}

.coursewareList {
  position: relative;
  padding: 0.266667rem 0.16rem 0;
}

.coursewareCtn {
  width: 9.68rem;
  height: 2.546667rem;
  margin-bottom: 0.213333rem;
  border-radius: 0.16rem;
  background-color: #ffffff;
}
.coursewareCtn .route {
  display: block;
  width: 100%;
  height: 100%;
}

.coursewareCtn .titleImg {
  float: left;
  margin-top: 0.25rem;
  margin-left: 0.453333rem;
  width: 3.333333rem;
  height: 2.093333rem;
  position: relative;
}

.coursewareCtn .titleImg img {
  width: 3.333333rem;
  height: 2.093333rem;
}

.coursewareCtn .titleImg span {
  display: block;
  width: 0.586667rem;
  height: 0.546667rem;
  background: url(../../images/crown.png);
  background-size: cover;
  -webkit-background-size: cover;
  position: absolute;
  top: -0.266667rem;
  right: -0.266667rem;
}
.coursewareCtn .titleCtn {
  float: left;
  height: 1.4rem;
}
.coursewareCtn p {
  width: 5.4rem;
  margin-top: 0.413333rem;
  margin-left: 0.36rem;
  color: #555555;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}

.coursewareCtn .getBtn {
  float: right;
  margin-right: 0.44rem;
  margin-top: 0.266667rem;
  color: #999999;
}

.coursewareCtn .getBtn .downloadBtn i {
  margin-left: 0.4rem;
}

.coursewareCtn .getBtn .downloadBtn span {
  display: inline-block;
  width: 2em;
}

.coursewareCtn .getBtn .downloadBtn .blue {
  color: #2a51ed;
}

</style>
