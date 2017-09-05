<template>
	<el-dialog :visible.sync="dialogVisible" custom-class="w-400 h-300" title="修改密码">
		<div class="ovf-auto">
			<el-form ref="form" :model="form" :rules="rules" label-width="80px">
				<el-form-item label="旧密码" prop="old_pwd">
					<el-input v-model.trim="form.old_pwd"></el-input>
				</el-form-item>
				<el-form-item label="新密码" prop="new_pwd">
					<el-input v-model.trim="form.new_pwd"></el-input>
				</el-form-item>
			</el-form>
		</div>
		<div class="p-t-20">
			<el-button type="primary" class="fl m-l-20" :disabled="disable" @click="submit()">提交</el-button>
		</div>
	</el-dialog>
</template>
<style>

</style>
<script>
  import http from '../../assets/js/http'

  export default {
    data() {
      return {
      	dialogVisible: false,
        disable: false,
        form: {
          auth_key: '',
          old_pwd: '',
          new_pwd: ''
        },
        rules: {
          old_pwd: [
            { required: true, message: '请输入旧密码', trigger: 'blur' },
            { min: 6, max: 12, message: '长度在 6 到 12 个字符', trigger: 'blur' }
          ],
          new_pwd: [
            { required: true, message: '请输入新密码', trigger: 'blur' },
            { min: 6, max: 12, message: '长度在 6 到 12 个字符', trigger: 'blur' }
          ]
        }
      }
    },
    methods: {
      open() {
        this.dialogVisible = true
      },
      close() {
        this.dialogVisible = false
      },
      submit() {
        this.$refs.form.validate((pass) => {
          if (pass) {
            this.disable = !this.disable
            this.apiPost('admin/base/setInfo', this.form).then((res) => {
              this.handelResponse(res, (data) => {
                _g.toastMsg('success', '修改成功')
                Lockr.rm('authKey')
                Lockr.rm('authList')
                Lockr.rm('sessionId')
                setTimeout(() => {
                  router.replace('/')
                }, 1500)
              }, () => {
                this.disable = !this.disable
              })
            })
          }
        })
      }
    },
    created() {
      this.form.auth_key = Lockr.get('authKey')
    },
    mixins: [http]
  }
</script>
