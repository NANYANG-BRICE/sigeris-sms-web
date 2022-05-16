<template>
	<v-col md="12" sm="12" cols="12" >
		<p class="text-2xl mb-6">
			Etudiants
			<span class="float-end">
				<v-btn 
					:loading="loading3" 
					:disabled="loading3" 
					color="blue-grey" 
					class="ma-2 white--text" 
					@click="loader = 'loading3'"> 
				 		Upload <v-icon right dark > mdi-cloud-upload</v-icon>
				</v-btn>
			</span>
		</p>
		<v-card id="account-setting-card">
			<!-- tabs -->
			<v-tabs v-model="tab" show-arrows >
				<v-tab v-for="tab in tabs" :key="tab.icon" block >
					<v-icon size="20" class="me-3" >
						{{ tab.icon }}
					</v-icon>
					<span>{{ tab.title }}</span>
				</v-tab>
			</v-tabs>

			<!-- tabs item -->
			<v-tabs-items v-model="tab">
				<v-tab-item>
					<account-settings-account></account-settings-account>
				</v-tab-item>

				<v-tab-item>
					<account-settings-security></account-settings-security>
				</v-tab-item>

				<v-tab-item>
					<account-settings-info></account-settings-info>
				</v-tab-item>
			</v-tabs-items>
		</v-card>
	</v-col>
</template>

<script>
	import { mdiAccountOutline, mdiLockOpenOutline, mdiInformationOutline } from '@mdi/js'
	import { ref } from '@vue/composition-api'



	// demos
	import AccountSettingsAccount from './components/Actif/Student_Actif.vue'
	import AccountSettingsSecurity from './components/Inactif/Student_Inactif.vue'
	import AccountSettingsInfo from './components/Latent/Student_Latent.vue'

	export default {
		components: {
			AccountSettingsAccount,
			AccountSettingsSecurity,
			AccountSettingsInfo,
		},

		data(){
			return {
				user: [],
				errors: [],
			}
		},
		 
		setup() {
		    const tab = ref('')

		    const tabs = [
			    { title: 'Actifs', icon: mdiAccountOutline },
			    { title: 'Inactifs', icon: mdiLockOpenOutline },
			    { title: 'Latents', icon: mdiInformationOutline },
		    ]

		    // account settings data
		    const accountSettingData = {
		    }

		    return {
		    	tab,
		    	tabs,
		    	accountSettingData,
		    	icons: {
		    		mdiAccountOutline,
		    		mdiLockOpenOutline,
		    		mdiInformationOutline,
		    	},
		    }
		},
	}
</script>