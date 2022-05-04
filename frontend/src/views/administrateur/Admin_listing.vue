<template>
	<v-col md="12" sm="12" cols="12" >

		<p class="text-2xl mb-6">
			Administrateur
		</p>
		<v-card>
			<v-card-title>
				Listing Administrator
			</v-card-title>

			<v-card-text>
				<data-table v-bind="listing_administrator" @actionTriggered="handleAction"/>
			</v-card-text>
		</v-card>
	</v-col>
</template>

<script>
	import { ref } from '@vue/composition-api'
	import axios from "axios";
	import {useRouter} from "vue-router";
	import ActionButtons from "./components/ActionButtons"
	//import Tooltip from "../../components/Tooltip.vue";

	export default {
		setup() {
			const statusColor = {
				Current: 'primary',
				Professional: 'success',
				Rejected: 'error',
				Resigned: 'warning',
				Applied: 'info',
		    }
		},

		data(){
			return {
				user: [],
				errors: []
			}
		},

		created() {
			this.getAdministrator();
		},

		computed: {
			listing_administrator() {
				return {
					data: this.user,
					actionMode: "multiple",
					columns: [
						{ 
							key: "admin_matricule",
							title: "Matricule"
						},

						{ 
							key: "admin_lastname",
							title: "Noms"
						},

						{ 
							key: "admin_firstname",
							title: "Prénoms"
						},

						{ 
							key: "admin_contact1",
							title: "Contact"
						},

						{ 
							key: "admin_email",
							title: "Email"
						},

						{ 
							key: "admin_statut",
							title: "Statut"
						},

						{
							key:"actions",
							title:"Actions",
							component: ActionButtons,
						},
					]
				};
			}
		},

		methods: {
			handleAction(actionName, data) {
				console.log(actionName, data);
				window.alert("check out the console");
			},

			async getAdministrator() {
				try {
					const response = await axios.get("Getting_admin");
					this.user = response.data;
					console.log(this.user);
				} 
				catch (error) {
					console.log(error);
				}
			},
		}
	}
</script>