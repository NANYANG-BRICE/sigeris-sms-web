<template>
	<v-card>
		<v-card-title class="mt-3">
			Actif Students
		</v-card-title>

		<v-card-text>
			<data-table v-bind="listing_student" @actionTriggered="handleAction"/>
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
				student: [],
				errors: [],
			}
		},

		created() {
			this.getAdministrator();
		},


		computed: {
			listing_student() {
				return {
					data: this.student,
					actionMode: "multiple",
					columns: [
						{ 
							key: "etudiant_matricule",
							title: "Matricule"
						},

						{ 
							key: "etudiant_lastname",
							title: "Noms"
						},

						{ 
							key: "etudiant_firstname",
							title: "Prénoms"
						},

						{ 
							key: "etudiant_contact1",
							title: "Contact"
						},

						{ 
							key: "etudiant_email_adress",
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
					const response = await axios.get("Getting_student");
					this.student = response.data.actif;
					console.log(this.student);
				} 
				catch (error) {
					console.log(error);
				}
			},
		}
	}
</script>
