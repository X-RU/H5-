<template>
	<div>
		<footer style="background-color: white">
			<grid>
				<grid-item link="/" label="首页">
					<img slot="icon" src="http://p5s0bbd0l.bkt.clouddn.com/icon1.png">
				</grid-item>
				<grid-item :link="{ path: '/user/message'}" label="我的">
					<img slot="icon" src="http://p5s0bbd0l.bkt.clouddn.com/icon1.png">
				</grid-item>
			</grid>
		</footer>
	</div>
</template>

<script>
	import { Group, Grid, GridItem } from 'vux'

	export default{
		name: 'Footer',
		components: {
			Group,
			Grid,
			GridItem
    },
	}
</script>

<style scoped>
footer{
	width: 100%;
	height: 5em;
	position: fixed;
	bottom: 0;
	border-top-style: solid;
	border-top-color: black;
	border-top-width: 0.1em;
}
</style>

