<template>
	<v-card>
		<v-card-title class="mt-3">
			Unactif Administrator
		</v-card-title>

		<v-card-text>
			<data-table v-bind="listing_administrator" @actionTriggered="handleAction"/>
		</v-card-text>
	</v-card>
</template>

<script>
	import axios from "axios";
	import ActionButtons from "./ActionButtons"
	export default {
		props: {
			accountData: {
				type: Object,
				default: () => {},
			},
		},


		data(){
			return {
				user: [],
				errors: [],
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
					this.user = response.data.inactif;
					console.log(this.user);
				} 
				catch (error) {
					console.log(error);
				}
			},
		}
	}
</script>
