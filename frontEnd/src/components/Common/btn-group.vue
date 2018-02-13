<template>
	<div>
		<el-button :loading="enableLoading" size="small" @click="changeAttrInBtnGroup(1)" v-if="enableShow">启用</el-button>
		<el-button :loading="disableLoading" size="small" @click="changeAttrInBtnGroup(0)" v-if="enableShow">禁用</el-button>
		<el-button :loading="deleteLoading" size="small" @click="deleteDatasInBtnGroup()" v-if="deletesShow">删除</el-button>
	</div>
</template>

<script>
  import http from '../../assets/js/http'
  import _ from 'lodash'
  import _g from '@/assets/js/global'
  
  export default {
    props: ['selectedData', 'type'],
    data() {
      console.log(this.type)
      return {
        enableLoading: false,
        disableLoading: false,
        deleteLoading: false
      }
    },
    methods: {
      getUrl() {
        return 'admin/' + this.type
      },
      getSelectedIds() {
        let array = []
        _(this.selectedData).forEach((res) => {
          array.push(res.id)
        })
        return array
      },
      changeAttrInBtnGroup(cate) {
        if (!this.selectedData.length) {
          _g.toastMsg('warning', '请勾选数据')
          return
        }
        let word = ''
        if (cate == 1) {
          word = '启用'
          this.enableLoading = !this.enableLoading
        } else {
          this.disableLoading = !this.disableLoading
          word = '禁用'
        }
        let url = this.getUrl() + '/enables'
        let data = {
          ids: this.getSelectedIds(),
          status: cate
        }
        this.apiPost(url, data).then((res) => {
          this.handelResponse(res, (data) => {
            _g.toastMsg('success', word + '成功')
            setTimeout(() => {
              _g.shallowRefresh(this.$route.name)
            }, 1500)
          }, () => {
            if (cate == 1) {
              this.enableLoading = !this.enableLoading
            } else {
              this.disableLoading = !this.disableLoading
            }
          })
        })
      },
      deleteDatasInBtnGroup() {
        if (!this.selectedData.length) {
          _g.toastMsg('warning', '请勾选数据')
          return
        }
        this.deleteLoading = !this.deleteLoading
        let url = this.getUrl() + '/deletes'
        let data = {
          ids: this.getSelectedIds()
        }
        this.apiPost(url, data).then((res) => {
          this.handelResponse(res, (data) => {
            _g.toastMsg('success', res.data)
            setTimeout(() => {
              _g.shallowRefresh(this.$route.name)
            }, 1500)
          }, () => {
            this.deleteLoading = !this.deleteLoading
          })
        })
      }
    },
    computed: {
      enableShow() {
        return _g.getHasRule(this.type + '-enables')
      },
      deletesShow() {
        return _g.getHasRule(this.type + '-deletes')
      }
    },
    mixins: [http]
  }
</script>