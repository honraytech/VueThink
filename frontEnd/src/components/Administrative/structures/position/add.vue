<template>
	<div class="m-l-50 m-t-30 w-900">
		<el-form ref="form" :model="form" :rules="rules" label-width="130px">
			<el-form-item label="岗位名称" prop="name">
				<el-input v-model.trim="form.name" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item label="备注">
        <el-input
          type="textarea"
          class="w-200"
          :autosize="{ minRows: 2, maxRows: 4}"
          placeholder="请输入内容"
          v-model="form.remark">
        </el-input>
      </el-form-item>
			<el-form-item>
				<el-button type="primary" @click="add('form')" :loading="isLoading">提交</el-button>
				<el-button @click="goback()">返回</el-button>
			</el-form-item>
		</el-form>
	</div>
</template>
<script>
  import http from '../../../../assets/js/http'
  import fomrMixin from '../../../../assets/js/form_com'
  import _g from '@/assets/js/global'

  export default {
    data() {
      return {
        isLoading: false,
        form: {
          name: '',
          remark: ''
        },
        rules: {
          name: [
            { required: true, message: '请输入岗位名称', trigger: 'blur' }
          ]
        }
      }
    },
    methods: {
      add(form) {
        this.$refs[form].validate((valid) => {
          if (valid) {
            this.isLoading = true
            this.apiPost('admin/posts', this.form).then((res) => {
              this.handelResponse(res, (data) => {
                this.isLoading = false
                _g.toastMsg('success', '添加成功')
                setTimeout(() => {
                  this.goback()
                }, 1500)
              }, () => {
                this.isLoading = false
              })
            })
          }
        })
      }
    },
    created() {
      _g.closeGlobalLoading()
    },
    mixins: [http, fomrMixin]
  }
</script>