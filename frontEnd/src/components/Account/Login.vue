<template>
  <div>
    <el-form :model="form" :rules="rules2" ref="form" label-position="left" label-width="0px" class="demo-ruleForm card-box loginform">
      <h3 class="title">{{systemName}}</h3>
      <el-form-item prop="username">
        <el-input type="text" v-model="form.username" auto-complete="off" placeholder="账号"></el-input>
      </el-form-item>
      <el-form-item prop="password">
        <el-input type="password" v-model="form.password" auto-complete="off" placeholder="密码"></el-input>
      </el-form-item>
      <el-form-item v-show="requireVerify" prop="verifyCode">
        <el-input type="text" v-model="form.verifyCode" auto-complete="off" placeholder="验证码" class="w-150"></el-input>
        <img :src="verifyUrl" @click="refreshVerify()" class="verify-pos"/>
      </el-form-item>
      <el-checkbox v-model="checked" style="margin:0px 0px 35px 0px;">记住密码</el-checkbox>
      <el-form-item style="width:100%;">
        <el-button type="primary" style="width:100%;" v-loading="loading" @click.native.prevent="handleSubmit2('form')">登录</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
  import http from '../../assets/js/http'

  export default {
    data() {
      return {
        title: '',
        systemName: '',
        loading: false,
        form: {
          username: '',
          password: '',
          verifyCode: ''
        },
        requireVerify: false,
        verifyUrl: '',
        verifyImg: window.HOST + 'admin/base/getVerify',
        rules2: {
          username: [
            { required: true, message: '请输入账号', trigger: 'blur' }
          ],
          password: [
            { required: true, message: '请输入密码', trigger: 'blur' }
          ],
          verifyCode: [
            { required: false, message: '请输入验证码', trigger: 'blur' }
          ]
        },
        checked: false
      }
    },
    methods: {
      refreshVerify() {
        this.verifyUrl = ''
        setTimeout(() => {
          this.verifyUrl = this.verifyImg + '?v=' + moment().unix()
        }, 300)
      },
      handleSubmit2(form) {
        if (this.loading) return
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.loading = !this.loading
            let data = {}
            if (this.requireVerify) {
              data.username = this.form.username
              data.password = this.form.password
              data.verifyCode = this.form.verifyCode
            } else {
              data.username = this.form.username
              data.password = this.form.password
            }
            if (this.checked) {
              data.isRemember = 1
            } else {
              data.isRemember = 0
            }
            this.apiPost('admin/base/login', data).then((res) => {
              if (res.code != 200) {
                this.loading = !this.loading
                this.handleError(res)
              } else {
                this.refreshVerify()
                if (this.checked) {
                  Cookies.set('rememberPwd', true, { expires: 1 })
                }
                this.resetCommonData(res.data)
                _g.toastMsg('success', '登录成功')
              }
            })
          } else {
            return false
          }
        })
      },
      checkIsRememberPwd() {
        if (Cookies.get('rememberPwd')) {
          let data = {
            rememberKey: Lockr.get('rememberKey')
          }
          this.apiPost('admin/base/relogin', data).then((res) => {
            this.handelResponse(res, (data) => {
              this.resetCommonData(data)
            })
          })
        }
      }
    },
    created() {
      this.checkIsRememberPwd()
      this.apiPost('admin/base/getConfigs').then((res) => {
        this.handelResponse(res, (data) => {
          document.title = data.SYSTEM_NAME
          this.systemName = data.SYSTEM_NAME
          if (parseInt(data.IDENTIFYING_CODE)) {
            this.requireVerify = true
            this.rules2.verifyCode[0].required = true
          }
        })
      })
      this.verifyUrl = this.verifyImg
    },
    mounted() {
      window.addEventListener('keyup', (e) => {
        if (e.keyCode === 13) {
          this.handleSubmit2('form')
        }
      })
    },
    mixins: [http]
  }
</script>

<style>
.verify-pos {
	position: absolute;
	right: 100px;
	top: 0px;
}
.card-box {
	padding: 20px;
	/*box-shadow: 0 0px 8px 0 rgba(0, 0, 0, 0.06), 0 1px 0px 0 rgba(0, 0, 0, 0.02);*/
	-webkit-border-radius: 5px;
	border-radius: 5px;
	-moz-border-radius: 5px;
	background-clip: padding-box;
	margin-bottom: 20px;
	background-color: #F9FAFC;
	margin: 120px auto;
	width: 400px;
	border: 2px solid #8492A6;
}

.title {
	margin: 0px auto 40px auto;
	text-align: center;
	color: #505458;
}

.loginform {
	width: 350px;
	padding: 35px 35px 15px 35px;
}
</style>