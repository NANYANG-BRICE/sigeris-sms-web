<template>
	<v-col md="12" sm="12" cols="12" >

		<p class="text-2xl mb-6">
			Administrateur
		</p>
		<v-card>
			<v-toolbar color="deep-purple accent-1" dark flat >

				<template v-slot:extension>
					<v-tabs v-model="currentItem" fixed-tabs slider-color="white" >
						<v-tab v-for="item in items" :key="item" :href="'#tab-' + item" >
							{{ item }}
						</v-tab>
					</v-tabs>
				</template>
			</v-toolbar>

			<v-tabs-items v-model="currentItem">
				<v-tab-item v-for="item in items.concat(more)" :key="item" :value="'tab-' + item" >
					<v-card flat>
						<v-card-text>
							<h2>{{ item }}</h2>
							{{ text }}
						</v-card-text>
					</v-card>
				</v-tab-item>
			</v-tabs-items>
		</v-card>
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
		data(){
			return {
				user: [],
				errors: [],
				currentItem: 'tab-Web',
				items: [
					'Administrateurs Actif', 'Administrateurs Inactif', 'Administrateurs Latent'
				],
				text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ',
    
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

			addItem (item) {
				const removed = this.items.splice(0, 1)
				this.items.push(
					this.more.splice(this.more.indexOf(item), 1),
				)
				this.more.push(...removed)
				this.$nextTick(() => { this.currentItem = 'tab-' + item })
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