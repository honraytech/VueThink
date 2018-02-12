import axios from 'axios'
import bus from '@/assets/js/bus.js'
export default {
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
}
