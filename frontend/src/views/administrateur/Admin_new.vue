<template>
	<v-col md="12" sm="12" cols="12" >

		<p class="text-2xl mb-6">
			Administrateur
		</p>
		<v-card>
			<v-card-title>
				Registration Administrator
			</v-card-title>
			<v-form @submit.prevent="create_new_administrateur">
				<v-card-text>
					<v-stepper v-model="e1">
						<v-stepper-header>
							<v-stepper-step :complete="e1 > 1" step="1" >
								Informations Principales
							</v-stepper-step>

						<v-divider></v-divider>

						<v-stepper-step step="2">
							Informations Secondaires
						</v-stepper-step>
					</v-stepper-header>

					<v-stepper-items>
						<v-stepper-content step="1">
							<v-card class="mb-5" color="grey lighten-1" height="200px" >
								<v-row class="mt-2">
									<v-col md="6" cols="12" >
										<span class="invisible">.</span>
										<span class="text-danger">{{msg_admin_firstname}}</span>
											<v-text-field 
											:prepend-inner-icon="icons.mdiAccountOutline"
											v-model="admin_firstname"
											outlined
											label="First name"
											placeholder="Brice Emmanuel........"
											hide-details
											class="mb-3">
										</v-text-field>
									</v-col>

								<v-col md="6" cols="12" >
									<span class="invisible">.</span>
									<span class="text-danger">{{msg_admin_lastname}}</span>
									<v-text-field
									:prepend-inner-icon="icons.mdiAccountOutline"
									v-model="admin_lastname"
									outlined
									label="Last name"
									placeholder="Nanyang........"
									hide-details
									class="mb-3">
								</v-text-field>
							</v-col>
								</v-row>

								<v-row>
									<v-col md="6" cols="12" >
										<span class="invisible">.</span>
										<span class="text-danger">{{msg_admin_contact1}}</span>
										<v-text-field
											:prepend-inner-icon="icons.mdiCellphoneSettings"
											v-model="admin_contact1"
											type="text" 
											v-mask="'+237-###-###-###'"
											oninput="validity.valid||(value='');" 
											onpress="isNumber(event)"
											class="mb-3"
											outlined
											label="Contact Orange"
											placeholder="ex : 699.179.767············"
											hide-details>
										</v-text-field>
									</v-col>

									<v-col md="6" cols="12" >
										<span class="invisible">.</span>
										<span class="text-danger">{{msg_admin_contact2}}</span>
										<v-text-field
											:prepend-inner-icon="icons.mdiCellphoneSettings"
											v-model="admin_contact2"
											type="text" 
											v-mask="'+237-###-###-###'"
											oninput="validity.valid||(value='');" 
											onpress="isNumber(event)"
											class="mb-3"
											outlined
											label="Contact MTN"
											placeholder="ex : 671.407.609············"
											hide-details>
										</v-text-field>
									</v-col>
								</v-row>
							</v-card>

							<v-btn color="primary" @click="e1 = 2">
								Continuer
							</v-btn>

							<v-btn type="reset" >
								Annuler
							</v-btn>
						</v-stepper-content>

						<v-stepper-content step="2">
							<v-card class="mb-12" color="grey lighten-1" height="200px">
								<v-row class="mt-2">
									<v-col md="6" cols="12" >
										<span class="invisible">.</span>
										<span class="text-danger">{{msg_admin_username}}</span>
											<v-text-field 
												:prepend-inner-icon="icons.mdiAccountLockOutline"
												v-model="admin_username"
												outlined
												label="Username"
												placeholder="Nanyang Brice........"
												hide-details
												class="mb-3">
											</v-text-field>
										</v-col>

										<v-col md="6" cols="12" >
											<span class="invisible">.</span>
											<span class="text-danger">{{msg_admin_email}}</span>
											<v-text-field
											:prepend-inner-icon="icons.mdiEmailCheckOutline"
											v-model="admin_email"
											outlined
											label="Email"
											placeholder="nanyangbrice@gmail.com........"
											hide-details
											class="mb-3">
										</v-text-field>
									</v-col>
								</v-row>

								<v-row class="mt-2">
									<v-col md="12" cols="12" class="conatiner" >
										<span class="invisible">.</span>
										<span class="text-danger text-center">{{msg_admin_privileges}}</span>
										<v-autocomplete
											:prepend-inner-icon="icons.mdiAccountStarOutline"
											v-model="admin_privileges"
											:items="privileges"
											outlined
											chips
											small-chips
											placeholder="Selectionnez les privilèges....."
											label="Privilèges"
											multiple >
										</v-autocomplete>
									</v-col>
								</v-row>
							</v-card>

							<v-btn color="primary" type="submit">
								Enregistrer
							</v-btn>

							<v-btn  @click="e1 = 1" >
								Precedent
							</v-btn>
						</v-stepper-content>
					</v-stepper-items>
				</v-stepper>
			</v-card-text>
		</v-form>
	</v-card>
</v-col>
</template>

<script>
	import { 
		mdiAccountLockOutline, 
		mdiEmailCheckOutline,  
		mdiEyeOutline, 
		mdiEyeOffOutline, 
		mdiLockAlertOutline, 
		mdiAccountOutline, 
		mdiCellphoneSettings, 
		mdiCloudUploadOutline, 
		mdiAccountStarOutline, 
	} from '@mdi/js'

	import { ref } from '@vue/composition-api'
	import Swal from 'sweetalert2'
	import axios from "axios";
	import {useRouter} from "vue-router";

	export default {
		setup() {
			const isPasswordVisible = ref(false)
			const isPasswordVisible1 = ref(false)

			return {
				isPasswordVisible,
				isPasswordVisible1,
				icons: {
					mdiAccountLockOutline,
					mdiEmailCheckOutline,
					mdiEyeOutline,
					mdiEyeOffOutline,
					mdiLockAlertOutline,
					mdiAccountOutline,
					mdiCellphoneSettings,
					mdiCloudUploadOutline,
					mdiAccountStarOutline,
				},
			}
		},

		data () {
			return {
				e1: 1,
				admin_firstname: "",
				admin_lastname: "",
				admin_contact1: "",
				admin_contact2: "",
				admin_username: "",
				admin_email: "",
				admin_privileges: [] ,

				privileges: [
					'student_edit', 
					'student_deasable', 
					'student_delete', 
					'student_print_single_report', 
					'student_print_global_report', 
					'student_print_liste', 
					'student_list',
					'student_reinitialize',
					'student_all',
					'all_privileges',
				],

				msg_admin_firstname: "",
				msg_admin_lastname: "",
				msg_admin_contact1: "",
				msg_admin_contact2: "",
				msg_admin_username: "",
				msg_admin_email: "",
				msg_admin_privileges: "",
			}
		},



		methods: {
			async create_new_administrateur() {
				try{
					const response 			=  await axios.post("Create_admin", {
						admin_email: 			this.admin_email,
						admin_lastname: 	this.admin_lastname,
						admin_contact1: 	this.admin_contact1,
						admin_contact2: 	this.admin_contact2,
						admin_username: 	this.admin_username,
						admin_firstname: 	this.admin_firstname,
						admin_privileges: this.admin_privileges,
					});

					(this.admin_firstname = ""),
					(this.admin_lastname  = ""),
					(this.admin_contact1  = ""),
					(this.admin_contact2  = ""),
					(this.admin_username  = ""),
					(this.admin_email 		= ""),
					(this.admin_privileges= ""),

					console.log(response.data);

					if (response.data.error === true) {
						Swal.fire({
              icon:   response.data.icon,
              title:  response.data.title,
              text:   response.data.alert,
              timer:  response.data.timer,
              backdrop: true, 
              allowOutsideClick: false,
              confirmButtonText: "Continuer",
						})
						this.msg_admin_firstname 		= response.data.msg.admin_firstname;
						this.msg_admin_lastname 		= response.data.msg.admin_lastname;
						this.msg_admin_contact1 		= response.data.msg.admin_contact1;
						this.msg_admin_contact2 		= response.data.msg.admin_contact2;
						this.msg_admin_username 		= response.data.msg.admin_username;
						this.msg_admin_email 				= response.data.msg.admin_email;
						this.msg_admin_privileges 	= response.data.msg.admin_privileges;
					}
					else{
						this.$router.push("/administrateur/create-account");
						Swal.fire({
              icon:   response.data.icon,
              title:  response.data.title,
              text:   response.data.alert,
              timer:  response.data.timer,
              backdrop: true, 
              allowOutsideClick: false,
              confirmButtonText: "Continuer",
						});
					}
				}
				catch (error) {
					console.log(error);
				}
			},
		},
	}

	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		let charCode = (evt.which) ? evt.which : evt.keyCode;
		if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
			evt.preventDefault();
		} else {
			return true;
		}
	}
</script>


<style>
  .text-danger {
    color: #dc3545 !important;
  }
  .invisible {
  	visibility: hidden !important;
  }
</style>