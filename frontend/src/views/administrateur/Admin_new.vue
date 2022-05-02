<template>
	<v-col md="12" sm="12" cols="12" >

		<p class="text-2xl mb-6">
			Administrateur
		</p>
		<v-card>
			<v-card-title>
				Registration Administrator
			</v-card-title>
			<v-form @submit.prevent="Registration" enctype="multipart/form-data">
				<v-card-text>
					<v-stepper v-model="e1">
						<v-stepper-header>
							<v-stepper-step :complete="e1 > 1" step="1" >
								Step 1
							</v-stepper-step>

						<v-divider></v-divider>

						<v-stepper-step :complete="e1 > 2" step="2" >
							Step 2
						</v-stepper-step>

						<v-divider></v-divider>

						<v-stepper-step step="3">
							Step 3
						</v-stepper-step>
					</v-stepper-header>

					<v-stepper-items>
						<v-stepper-content step="1">
							<v-card class="mb-5" color="grey lighten-1" height="200px">
								<v-row class="mt-2">
									<v-col md="6" cols="12" >
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
										<span class="text-danger">{{msg_admin_username}}</span>
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

								<v-row>
									<v-col md="6" cols="12" >
										<span class="text-danger">{{msg_admin_password}}</span>
										<v-text-field
											class="mb-3"
											:prepend-inner-icon="icons.mdiLockAlertOutline"
											v-model="admin_password"
											outlined
											:type="isPasswordVisible1 ? 'text' : 'password'"
											label="Password"
											placeholder="············"
											:append-icon="isPasswordVisible1 ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
											hide-details
											@click:append="isPasswordVisible1 = !isPasswordVisible1">
										</v-text-field>
									</v-col>

									<v-col md="6" cols="12" >
										<span class="text-danger">{{msg_admin_password}}</span>
										<v-text-field
											class="mb-3"
											:prepend-inner-icon="icons.mdiLockAlertOutline"
											v-model="admin_password"
											outlined
											:type="isPasswordVisible ? 'text' : 'password'"
											label="Confirm Password"
											placeholder="············"
											:append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
											hide-details
											@click:append="isPasswordVisible = !isPasswordVisible">
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
							<v-card class="mb-5" color="grey lighten-1" height="200px" >
								<v-row class="mt-2">
									<v-col md="6" cols="12" >
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
										<span class="text-danger">{{msg_admin_contact1}}</span>
										<v-text-field
											:prepend-inner-icon="icons.mdiCellphoneSettings"
											v-model="admin_contact1"
											type="number" 
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
										<span class="text-danger">{{msg_admin_contact2}}</span>
										<v-text-field
											:prepend-inner-icon="icons.mdiCellphoneSettings"
											v-model="admin_contact2"
											type="number" 
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

							<v-btn color="primary" @click="e1 = 3">
								Continuer
							</v-btn>

							<v-btn @click="e1 = 1" >
								precedent
							</v-btn>
						</v-stepper-content>

						<v-stepper-content step="3">
							<v-card class="mb-12" color="grey lighten-1" height="100px">
								<v-row class="mt-2">
									<v-col md="12" cols="12" class="conatiner" >
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

							<v-btn  @click="e1 = 2" >
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

			const handleFileUpload = async() => {
				console.log("selected file",file.value.files)
			}

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
				admin_username: "",
				admin_email: "",
				admin_password: "",
				admin_firstname: "",
				admin_lastname: "",
				admin_lastname: "",
				admin_contact1: "",
				admin_contact2: "",
				admin_privileges: [],

				privileges: [
					'foo', 
					'bar', 
					'fizz', 
					'buzz'
				],

				msg_admin_username: "",
				msg_admin_email: "",
				msg_admin_password: "",
				msg_admin_firstname: "",
				msg_admin_lastname: "",
				msg_admin_lastname: "",
				msg_admin_contact1: "",
				msg_admin_contact2: "",
				msg_admin_picture: "",
				msg_admin_privileges: "",
			}
		},



		methods: {
			async Registration() {
				try{
					const response =  await axios.post("Create_admin", {
						admin_username: this.admin_username,
						admin_email: 	this.admin_email,
						admin_password: this.admin_password,
						admin_firstname:this.admin_firstname,
						admin_lastname: this.admin_lastname,
						admin_lastname: this.admin_lastname,
						admin_contact1: this.admin_contact1,
						admin_contact2: this.admin_contact2,
						admin_privileges: this.admin_privileges,
						admin_password: this.admin_password,
					});
					(this.file= ""),
					(this.admin_username= ""),
					(this.admin_email= ""),
					(this.admin_password= ""),
					(this.admin_firstname= ""),
					(this.admin_lastname= ""),
					(this.admin_lastname= ""),
					(this.admin_contact1= ""),
					(this.admin_contact2= ""),
					(this.admin_privileges= ""),

					console.log(response.data);
					if (response.data.error === true) {
						Swal.fire({
							backdrop:true, 
							allowOutsideClick: false,
							confirmButtonText: "Je comprend !",
							icon: 'error',
							title: 'Failed !',
							text: 'Erreur survenue durant l\'enregistrement...',
							timer: 15000,
						})
						if(response.data.msg.admin_username) {
							this.msg_admin_username = response.data.msg.admin_email
						}
						if(response.data.msg.admin_email) {
							this.msg_admin_email = response.data.msg.admin_email
						}
						if(response.data.msg.admin_password) {
							this.msg_admin_password = response.data.msg.admin_password
						}
						if(response.data.msg.admin_firstname) {
							this.msg_admin_firstname = response.data.msg.admin_firstname
						}
						if(response.data.msg.admin_lastname) {
							this.msg_admin_lastname = response.data.msg.admin_lastname
						}
						if(response.data.msg.admin_contact1) {
							this.msg_admin_contact1 = response.data.msg.admin_contact1
						}
						if(response.data.msg.admin_contact2) {
							this.msg_admin_contact2 = response.data.msg.admin_contact2
						}
					}
					else{
						this.$router.push("/");
						Swal.fire({
							width: 340,
							toast: true,
							timer: 5000,
							icon : 'success',
							position: 'top-end',
							showConfirmButton: false,
							title : 'Félicitations',
							text: 'Connexion établie.',
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