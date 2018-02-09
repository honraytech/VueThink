<template>
  <div class="m-l-50 m-t-30 w-900">
    <el-form ref="form" :model="form" :rules="rules" label-width="130px">
      <el-form-item label="用户组名称" prop="title">
        <el-input v-model.trim="form.title" class="h-40 w-200"></el-input>
      </el-form-item>
      <el-form-item label="父级用户组" prop="pid">
        <el-select v-model="form.pid" placeholder="父级用户组" class="w-200">
          <el-option v-for="item in options" :label="item.title" :value="item.id" :key="item.id"></el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="备注">
        <el-input
          type="textarea"
          :rows="2"
          placeholder="备注"
          v-model="form.remark"
          class="w-200">
        </el-input>
      </el-form-item>
      <el-form-item label="权限分配">
        <div class="bor-gray h-400 ovf-y-auto bor-ra-5 bg-wh">
          <div v-for="item in nodes" :key="item.id">
            <div class="bor-b-ccc bg-gra p-l-10 p-r-10">
              <el-checkbox v-model="item.check" @change="selectProjectRule(item)">{{item.else}}</el-checkbox>
            </div>
            <div v-for="childItem in item.child" :key="childItem.id">
              <div class="p-l-20 bor-b-ccc">
                <el-checkbox v-model="childItem.check" @change="selectModuleRule(childItem, item, childItem.child)">{{childItem.else}}</el-checkbox>
              </div>
              <div class="p-l-40 bor-b-ccc bg-gra">
                <el-checkbox v-for="grandChildItem in childItem.child" :key="grandChildItem.id" v-model="grandChildItem.check" @change="selectActionRule(grandChildItem, childItem, item)">{{grandChildItem.else}}</el-checkbox>
              </div>
            </div>
          </div>
        </div>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="edit('form')" :loading="isLoading">提交</el-button>
        <el-button @click="goback()">返回</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
  import http from '../../../../assets/js/http'
  import fomrMixin from '../../../../assets/js/form_com'

  export default {
    data() {
      return {
        isLoading: false,
        form: {
          id: null,
          title: '',
          pid: '',
          remark: '',
          rules: '',
          status: null
        },
        options: [{ pid: '0', title: '无' }],
        nodes: [],
        selectedNodes: [],
        rules: {
          title: [
            { required: true, message: '请输入用户组名称', trigger: 'blur' }
          ]
        }
      }
    },
    methods: {
      edit(form) {
        this.form.rules = this.selectedNodes.toString()
        this.$refs[form].validate((valid) => {
          if (valid) {
            this.isLoading = true
            this.apiPut('admin/groups/', this.form.id, this.form).then((res) => {
              this.handelResponse(res, (data) => {
                this.isLoading = false
                _g.toastMsg('success', '编辑成功')
                setTimeout(() => {
                  this.goback()
                }, 1500)
              }, () => {
                this.isLoading = false
              })
            })
          }
        })
      },
      getRules() {
        return new Promise((resolve, reject) => {
          this.apiGet('admin/rules?type=tree').then((res) => {
            this.handelResponse(res, (data) => {
              resolve(data)
            })
          })
        })
      },
      getGroups() {
        this.apiGet('admin/groups').then((res) => {
          this.handelResponse(res, (data) => {
            _(data).forEach((ret) => {
              ret.id = ret.id.toString()
            })
            this.options = this.options.concat(data)
          })
        })
      },
      async getGroupInfo() {
        this.form.id = this.$route.params.id
        let arr = await this.getRules()
        this.nodes = this.nodes.concat(arr)
        this.apiGet('admin/groups/' + this.form.id).then((res) => {
          this.handelResponse(res, (data) => {
            this.form.title = data.title
            this.form.pid = data.pid ? data.pid.toString() : ''
            this.form.remark = data.remark
            this.form.status = data.status
            let array = data.rules.split(',')
            _(array).forEach((ret) => {
              this.selectedNodes.push(parseInt(ret))
            })
            _(this.nodes).forEach((ret) => {
              if (_.includes(this.selectedNodes, ret.id)) {
                ret.check = true
              }
              _(ret.child).forEach((ret1) => {
                if (_(this.selectedNodes).includes(ret1.id)) {
                  ret1.check = true
                }
                _(ret1.child).forEach((ret2) => {
                  if (_(this.selectedNodes).includes(ret2.id)) {
                    ret2.check = true
                  }
                })
              })
            })
          })
        })
      },
      selectProjectRule(item) {
        if (!item.check) {
          _(item.child).forEach((res) => {
            res.check = false
            let index = _(this.selectedNodes).indexOf(res.id)
            this.selectedNodes.splice(index, 1)
            _(res.child).forEach((res1) => {
              res1.check = false
              let index = _(this.selectedNodes).indexOf(res1.id)
              this.selectedNodes.splice(index, 1)
            })
          })
        }
        this.selectRule(item)
      },
      selectModuleRule(item, faItem, children) {
        if (!faItem.check) {
          faItem.check = true
          this.selectedNodes.push(faItem.id)
        }
        if (item.check) {
          this.selectedNodes.push(item.id)
          _(children).forEach((res) => {
            res.check = true
            this.selectedNodes.push(res.id)
          })
        } else {
          let index = _(this.selectedNodes).indexOf(item.id)
          this.selectedNodes.splice(index, 1)
          _(children).forEach((res1) => {
            let temp = _(this.selectedNodes).indexOf(res1.id)
            if (temp >= 0) {
              res1.check = false
              this.selectedNodes.splice(temp, 1)
            }
          })
        }
      },
      selectActionRule(item, faItem, grandFaItem) {
        if (!faItem.check) {
          faItem.check = true
          this.selectedNodes.push(faItem.id)
        }
        if (!grandFaItem.check) {
          grandFaItem.check = true
          this.selectedNodes.push(grandFaItem.id)
        }
        this.selectRule(item)
      },
      selectRule(item) {
        if (item.check) {
          this.selectedNodes.push(item.id)
        } else {
          const index = _(this.selectedNodes).indexOf(item.id)
          this.selectedNodes.splice(index, 1)
        }
      }
    },
    created() {
      this.getGroupInfo()
      this.getGroups()
    },
    mixins: [http, fomrMixin]
  }
</script>