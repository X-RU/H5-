import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/components/Home'
import Release from '@/components/Release'
import Enroll from '@/components/Enroll'
import Manager from '@/components/Manager'
import Photos from '@/components/Photos'
import Profile from '@/components/Profile'
import Members from '@/components/Members'
import Mine from '@/components/Mine'

Vue.use(Router)

export default new Router({
	routes: [
		{
			path: '/',
			name: 'Home',
			component: Home
		},
		// {
		// 	path: '/index',
		// 	name: 'Home',
		// 	component: Home
		// },
		{
			path: '/release',
			name: 'Release',
			component: Release
		},
		{
			path: '/project/detailed/:id',
			name: 'Enroll',
			component: Enroll
		},
		{
			path: '/project/manager/:id',
			name: 'Manager',
			component: Manager

		},
		{
			path: '/photos',
			name: 'Photos',
			component: Photos
		},
		{
			path: '/user/message',
			name: 'Profile',
			component: Profile
		},
		{
			path: '/project/relationPeople/:id',
			name: 'Members',
			component: Members
		},
		{
			path: '/mine',
			name: 'Mine',
			component: Mine
		}
	]
})
