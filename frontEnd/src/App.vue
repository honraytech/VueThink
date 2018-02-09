<template>
	<div id="app">
		<transition name="bounce">
			<router-view></router-view>
		</transition>
	</div>
</template>

<script>
export default {
  name: 'app',
  components: {
  }
}
</script>

<style>
	@import "assets/css/font-awesome.min.css";
	.bounce-enter-active {
		animation: bounce-in .5s;
	}

	.bounce-leave-active {
		animation: bounce-out .2s;
	}

	@keyframes bounce-in {
		0% {
			transform: scale(0);
		}
		50% {
			transform: scale(1.05);
		}
		100% {
			transform: scale(1);
		}
	}

	@keyframes bounce-out {
		0% {
			transform: scale(1);
		}
		50% {
			transform: scale(0.95);
		}
		100% {
			transform: scale(0);
		}
	}
	/* 滚动条样式 */
	::-webkit-scrollbar {
	width: 6px;
	background-color: #f1f2f7;
	}
	::-webkit-scrollbar-thumb {
	background-color: #c1c1c1;
	border-radius: 4px;
	}

	::-moz-scrollbar {
	width: 6px;
	background-color: transparent;
	}
	::-moz-scrollbar-thumb {
	background-color: #c1c1c1;
	border-radius: 4px;
	}
	html{
		height: 100%;
		width: 100%;
		margin: 0;
		padding: 0;
	}
	body {
		margin: 0px;
		padding: 0px;
		background: #1F2D3D;
		font-family: Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB, Microsoft YaHei, SimSun, sans-serif;
		font-weight: 400;
		-webkit-font-smoothing: antialiased;
		height: 100%;
		width: 100%;
		overflow: hidden;
	}

	#app {
		position: absolute;
		top: 0px;
		bottom: 0px;
		width: 100%;
	}

	.el-submenu [class^=fa] {
		vertical-align: baseline;
		margin-right: 10px;
	}

	.el-menu-item [class^=fa] {
		vertical-align: baseline;
		margin-right: 10px;
	}
</style>