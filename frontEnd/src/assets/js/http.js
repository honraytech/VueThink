import store from '@/vuex/store'
import router from '@/router/index.js'
import axios from 'axios'
import Lockr from 'lockr'
import Cookies from 'js-cookie'
import _ from 'lodash'
import _g from '@/assets/js/global'
import bus from '@/assets/js/bus.js'
import config from '@/assets/js/config.js'

axios.defaults.baseURL = config.HOST
axios.defaults.timeout = 1000 * 15
axios.defaults.headers.authKey = Lockr.get('authKey')
axios.defaults.headers.sessionId = Lockr.get('sessionId')
axios.defaults.headers['Content-Type'] = 'application/json'

const apiMethods = {
  methods: {
    apiGet(url, data) {
      return new Promise((resolve, reject) => {
        axios.get(url, data).then((response) => {
          resolve(response.data)
        }, (response) => {
          reject(response)
          _g.closeGlobalLoading()
          bus.$message({
            message: '请求超时，请检查网络',
            type: 'warning'
          })
        })
      })
    },
    apiPost(url, data) {
      return new Promise((resolve, reject) => {
        axios.post(url, data).then((response) => {
          resolve(response.data)
        }).catch((response) => {
          resolve(response)
          bus.$message({
            message: '请求超时，请检查网络',
            type: 'warning'
          })
        })
      })
    },
    apiDelete(url, id) {
      return new Promise((resolve, reject) => {
        axios.delete(url + id).then((response) => {
          resolve(response.data)
        }, (response) => {
          reject(response)
          _g.closeGlobalLoading()
          bus.$message({
            message: '请求超时，请检查网络',
            type: 'warning'
          })
        })
      })
    },
    apiPut(url, id, obj) {
      return new Promise((resolve, reject) => {
        axios.put(url + id, obj).then((response) => {
          resolve(response.data)
        }, (response) => {
          _g.closeGlobalLoading()
          bus.$message({
            message: '请求超时，请检查网络',
            type: 'warning'
          })
          reject(response)
        })
      })
    },
    handelResponse(res, cb, errCb) {
      _g.closeGlobalLoading()
      if (res.code == 200) {
        cb(res.data)
      } else {
        if (typeof errCb == 'function') {
          errCb()
        }
        this.handleError(res)
      }
    },
    handleError(res) {
      if (res.code) {
        switch (res.code) {
          case 101:
            if (Cookies.get('rememberPwd')) {
              let data = {
                rememberKey: Lockr.get('rememberKey')
              }
              this.reAjax('admin/base/relogin', data).then((res) => {
                this.handelResponse(res, (data) => {
                  this.resetCommonData(data)
                })
              })
            } else {
              _g.toastMsg('error', res.error)
              setTimeout(() => {
                router.replace('/')
              }, 1500)
            }
            break
          case 103:
            _g.toastMsg('error', res.error)
            setTimeout(() => {
              router.replace('/')
            }, 1500)
            break
          // case 400:
          //   this.goback()
          //   break
          default :
            _g.toastMsg('error', res.error)
        }
      } else {
      }
    },
    resetCommonData(data) {
      _(data.menusList).forEach((res, key) => {
        if (key == 0) {
          // 选中第一个一级菜单
          res.selected = true
        } else {
          res.selected = false
        }
      })
      Lockr.set('authKey', data.authKey)              // 权限认证
      Lockr.set('rememberKey', data.rememberKey)      // 记住密码的加密字符串
      store.dispatch('setMenus', data.menusList)      // 菜单信息
      store.dispatch('setRules', data.authList)       // 权限信息
      store.dispatch('setUsers', data.userInfo)       // 用户信息
      axios.defaults.headers.authKey = Lockr.get('authKey')
      let routerUrl = ''
      if (data.menusList[0].url) {
        routerUrl = data.menusList[0].url
      } else {
        routerUrl = data.menusList[0].child[0].child[0].url
      }
      setTimeout(() => {
        let path = this.$route.path
        if (routerUrl != path) {
          router.replace(routerUrl)
        } else {
          _g.shallowRefresh(this.$route.name)
        }
      }, 1000)
    },
    reAjax(url, data) {
      return new Promise((resolve, reject) => {
        axios.post(url, data).then((response) => {
          resolve(response.data)
        }, (response) => {
          reject(response)
          bus.$message({
            message: '请求超时，请检查网络',
            type: 'warning'
          })
        })
      })
    }
  },
  computed: {
    showLoading() {
      return store.state.globalLoading
    }
  }
}

export default apiMethods
