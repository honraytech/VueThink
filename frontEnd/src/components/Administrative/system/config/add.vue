<template>
	<div class="m-l-50 m-t-30 w-500">
		<el-form ref="form" :model="form" :rules="rules" label-width="130px">
			<el-form-item label="系统名称" prop="SYSTEM_NAME">
				<el-input v-model.trim="form.SYSTEM_NAME" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item label="LOGO">
				<el-upload
        class="upload-demo"
				:action="uploadUrl"
				drag
				:thumbnail-mode="true"
				:on-preview="viewPic"
				:on-remove="handleRemove"
				:on-success="uploadSuccess"
				:on-error="uploadFail"
				:default-file-list="fileList">
					<i class="el-icon-upload"></i>
					<div class="el-dragger__text">将文件拖到此处，或<em>点击上传</em></div>
					<div class="el-upload__tip" slot="tip">只能上传jpg/png文件</div>
				</el-upload>
			</el-form-item>
      <el-form-item label="LOGO类型">
        <el-radio-group v-model="form.LOGO_TYPE">
          <el-radio label="1">图片</el-radio>
          <el-radio label="2">文字</el-radio>
        </el-radio-group>
      </el-form-item>
			<el-form-item label="登录验证码">
				<el-radio-group v-model="form.IDENTIFYING_CODE">
					<el-radio label="1">打开</el-radio>
					<el-radio label="0">关闭</el-radio>
				</el-radio-group>
			</el-form-item>
			<el-form-item label="登录会话有效期" prop="LOGIN_SESSION_VALID">
				<el-input v-model.number="form.LOGIN_SESSION_VALID" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item>
				<el-button type="primary" @click="add()" :loading="isLoading">提交</el-button>
			</el-form-item>
		</el-form>
		<preview ref="preview" :url="propsImg"></preview>
	</div>
</template>
<script>
  import http from '../../../../assets/js/http'
  import preview from './preview.vue'

  export default {
    data() {
      return {
        isLoading: false,
        fileList: [],
        propsImg: '',
        form: {
          SYSTEM_NAME: '',
          IDENTIFYING_CODE: '0',
          LOGO_TYPE: '1',
          LOGIN_SESSION_VALID: null,
          SYSTEM_LOGO: ''
        },
        uploadUrl: '',
        rules: {
          SYSTEM_NAME: [
            { required: true, message: '请输入系统名称' }
          ],
          LOGIN_SESSION_VALID: [
            { required: true, message: '请输入登录有效期' },
            { type: 'number', message: '请输入数字' }
          ]
        }
      }
    },
    methods: {
      add() {
        this.$refs.form.validate((pass) => {
          if (pass) {
            this.isLoading = !this.isLoading
            this.apiPost('admin/systemConfigs', this.form).then((res) => {
              this.handelResponse(res, (data) => {
                _g.toastMsg('success', '提交成功')
                this.isLoading = !this.isLoading
              }, () => {
                this.isLoading = !this.isLoading
              })
            })
          }
        })
      },
      uploadSuccess(res, file, fileList) {
        this.form.SYSTEM_LOGO = res.data
        let data = {
          name: '图片',
          url: window.HOST + res.data
        }
        if (this.fileList.length) {
          this.fileList[0] = data
        } else {
          this.fileList.push(data)
        }
      },
      uploadFail(err, res, file) {
        console.log('err = ', _g.j2s(err))
        console.log('res = ', _g.j2s(res))
      },
      handleRemove(file, fileList) {
        console.log('file = ', file)
        console.log('fileList = ', fileList)
      },
      viewPic() {
        this.propsImg = this.fileList[0].url
        this.$refs.preview.open()
      }
    },
    created() {
      this.uploadUrl = window.HOST + '/Upload'
      this.apiPost('admin/base/getConfigs').then((res) => {
        this.handelResponse(res, (data) => {
          this.form.SYSTEM_NAME = data.SYSTEM_NAME
          this.form.IDENTIFYING_CODE = data.IDENTIFYING_CODE
          this.form.LOGIN_SESSION_VALID = parseInt(data.LOGIN_SESSION_VALID)
          this.form.LOGO_TYPE = data.LOGO_TYPE
          if (data.SYSTEM_LOGO) {
            let img = window.HOST + data.SYSTEM_LOGO
            this.fileList.push({ name: '图片', url: img })
            this.form.SYSTEM_LOGO = data.SYSTEM_LOGO
          }
        })
      })
    },
    components: {
      preview
    },
    mixins: [http]
  }
</script>