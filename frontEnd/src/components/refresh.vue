<template>
	<div></div>
</template>
<script>
export default {
  created() {
    if (this.$route.query.name) {
      router.replace({ name: this.$route.query.name })
    } else {

    }
  }
}
</script>