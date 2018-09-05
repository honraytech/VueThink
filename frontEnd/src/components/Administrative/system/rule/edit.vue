<template>
  <div class="m-l-50 m-t-30 w-500">
    <el-form ref="form" :model="form" :rules="rules" label-width="110px">
      <el-form-item label="显示名" prop="title">
        <el-input v-model.trim="form.title" class="h-40 w-200"></el-input>
      </el-form-item>
      <el-form-item label="名称" prop="name">
        <el-input v-model.trim="form.name" class="h-40 w-200"></el-input>
      </el-form-item>
      <el-form-item label="节点类型" prop="level">
        <el-radio-group v-model="form.level">
          <el-radio label="1" disabled>项目</el-radio>
          <el-radio label="2" disabled>模块</el-radio>
          <el-radio label="3" disabled>操作</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="父节点" prop="pid">
        <el-select v-model="form.pid" placeholder="父节点" class="w-200" disabled>
          <el-option v-for="item in options" :label="item.title" :value="item.id"></el-option>
        </el-select>
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
          name: '',
          pid: null,
          level: null
        },
        options: [{ id: 0, name: '根节点' }],
        rules: {
          title: [
            { required: true, message: '请输入节点名称' }
          ],
          name: [
            { required: true, message: '请输入节点显示名' }
          ],
          level: [
            { required: true, message: '请选择节点类型' }
          ],
          pid: [
            { type: 'number', required: true, message: '请选择父级节点' }
          ]
        }
      }
    },
    methods: {
      edit(form) {
        this.$refs[form].validate((valid) => {
          if (valid) {
            this.isLoading = !this.isLoading
            this.apiPut('admin/rules/update/', this.form.id, this.form).then((res) => {
              this.handelResponse(res, (data) => {
                _g.toastMsg('success', '编辑成功')
                setTimeout(() => {
                  this.goback()
                }, 1500)
              }, () => {
                this.isLoading = !this.isLoading
              })
            })
          }
        })
      },
      getRules() {
        this.apiGet('admin/rules').then((res) => {
          this.handelResponse(res, (data) => {
            this.options = this.options.concat(data)
          })
        })
      },
      getRuleInfo() {
        this.form.id = this.$route.params.id
        this.apiGet('admin/rules/' + this.form.id).then((res) => {
          this.handelResponse(res, (data) => {
            data.level = data.level.toString()
            this.form = data
          })
        })
      }
    },
    created() {
      this.getRules()
      this.getRuleInfo()
    },
    mixins: [http, fomrMixin]
  }
</script>