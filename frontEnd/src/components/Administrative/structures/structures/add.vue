<template>
	<div class="m-l-50 m-t-30 w-900">
		<el-form ref="form" :model="form" :rules="rules" label-width="130px">
			<el-form-item label="部门名称" prop="name">
				<el-input v-model.trim="form.name" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item label="上级部门" prop="pid">
        <el-select v-model="form.pid" placeholder="上级部门" class="w-200">
          <el-option v-for="item in options" :label="item.title" :value="item.id"></el-option>
        </el-select>
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

  export default {
    data() {
      return {
        isLoading: false,
        form: {
          name: '',
          pid: ''
        },
        users: [],
        options: [{ pid: 0, title: '无' }],
        rules: {
          name: [
            { required: true, message: '请输入部门名称', trigger: 'blur' }
          ]
        }
      }
    },
    methods: {
      add(form) {
        this.$refs[form].validate((valid) => {
          if (valid) {
            this.isLoading = !this.isLoading
            this.apiPost('admin/structures', this.form).then((res) => {
              this.handelResponse(res, (data) => {
                _g.toastMsg('success', '添加成功')
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
      getStructures() {
        this.apiGet('admin/structures').then((res) => {
          this.handelResponse(res, (data) => {
            this.options = this.options.concat(data)
          })
        })
      }
    },
    created() {
      this.getStructures()
    },
    mixins: [http, fomrMixin]
  }
</script>