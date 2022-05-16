<template>
	<v-col md="12" sm="12" cols="12" >

		<p class="text-2xl mb-6">
			Etudiants
		</p>
		<v-card>
			<v-card-title>
				Registration Student
			</v-card-title>
			<v-form @submit.prevent="Registration" enctype="multipart/form-data">
					<v-card-text>
						<v-stepper v-model="e1">
							<v-stepper-header>
								<v-stepper-step :complete="e1 > 1" step="1" >
									Informations Principales
								</v-stepper-step>

								<v-divider></v-divider>

								<v-stepper-step :complete="e1 > 2" step="2" >
									Informations Secondaires
								</v-stepper-step>
							</v-stepper-header>
						</v-stepper-header>

						<v-stepper-items>
							<v-stepper-content step="1">
								<v-card class="mb-3" color="grey lighten-1" height="210px" >
									<v-row>
										<v-col md="6" cols="12" >
											<span class="invisible">5</span>
											<span class="text-danger">{{msg_etudiant_firstname}}</span>
												<v-text-field 
												:prepend-inner-icon="icons.mdiAccountOutline"
												v-model="etudiant_firstname"
												autocomplete="off"
												outlined
												label="First name"
												placeholder="Brice Emmanuel........"
												hide-details
												class="mb-3">
											</v-text-field>
										</v-col>

										<v-col md="6" cols="12" >
											<span class="invisible">5</span>
											<span class="text-danger">{{msg_etudiant_lastname}}</span>
											<v-text-field
												:prepend-inner-icon="icons.mdiAccountOutline"
												v-model="etudiant_lastname"
												outlined
												label="Last name"
														autocomplete="off"
												placeholder="Nanyang........"
												hide-details
												class="mb-3">
											</v-text-field>
										</v-col>
									</v-row>

									<v-row>
										<v-col md="6" cols="12" >
											<span class="invisible">5</span>
											<span class="text-danger">{{msg_etudiant_contact1}}</span>
											<v-text-field
												:prepend-inner-icon="icons.mdiCellphoneSettings"
												v-model="etudiant_contact1"
												type="text" 
												v-mask="'+237-###-###-###'"
												oninput="validity.valid||(value='');" 
												onpress="isNumber(event)"
												class="mb-3"
												outlined
												autocomplete="off"
												label="Contact Orange"
												placeholder="ex : 699.179.767············"
												hide-details>
											</v-text-field>
										</v-col>

										<v-col md="6" cols="12" >
											<span class="invisible">5</span>
											<v-text-field
												:prepend-inner-icon="icons.mdiCellphoneSettings"
												v-model="etudiant_contact2"
												type="text" 
												v-mask="'+237-###-###-###'"
												oninput="validity.valid||(value='');" 
												onpress="isNumber(event)"
												autocomplete="off"
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
								<v-card class="mb-5" color="grey lighten-1" height="210px" >
									<v-row>
										<v-col md="12" cols="12" >
											<span class="text-danger">{{msg_etudiant_email_adress}}</span>
											<v-text-field
												:prepend-inner-icon="icons.mdiEmailCheckOutline"
												v-model="etudiant_email_adress"
												outlined
												autocomplete="off"
												label="Email"
												placeholder="nanyangbrice@gmail.com........"
												hide-details
												class="mb-3">
											</v-text-field>
										</v-col>
									</v-row>
									<v-row>
										<v-col md="6" cols="12" >
											<span class="invisible">5</span>
											<span class="text-danger">{{msg_classe_etudiant}}</span>
											<v-autocomplete
												:prepend-inner-icon="icons.mdiHomeCityOutline"
												v-model="classe_etudiant"
												:items="classes"
												autocomplete="off"
												outlined
												chips
												small-chips
												label="Classe étudiant"
												single>
											</v-autocomplete>
										</v-col>

										<v-col md="6" cols="12">
											<span class="invisible">5</span>
											<v-autocomplete
												:prepend-inner-icon="icons.mdiAccountStarOutline"
												v-model="etudiant_privileges"
												:items="privileges"
												outlined
												autocomplete="off"
												chips
												small-chips
												placeholder="Selectionnez les privilèges....."
												label="Privilèges"
												multiple >
											</v-autocomplete>
										</v-col>
									</v-row>
								</v-card>

								<v-btn type="submit" color="primary">
									Enregistrer
								</v-btn>

								<v-btn @click="e1 = 1" >
									precedent
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
		mdiHomeCityOutline, 
		mdiAccountHardHat, 
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
					mdiHomeCityOutline, 
					mdiAccountHardHat, 
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
				etudiant_email_adress: "",
				etudiant_firstname: "",
				etudiant_lastname: "",
				etudiant_contact1: "",
				etudiant_contact2: "",
				classe_etudiant: "",
				etudiant_privileges: [],

				privileges: [
					'foo', 
					'bar', 
					'fizz', 
					'buzz'
				],

				classes: [],

				msg_etudiant_email_adress: "",
				msg_etudiant_firstname: "",
				msg_etudiant_lastname: "",
				msg_etudiant_contact1: "",
				msg_etudiant_contact2: "",
				msg_classe_etudiant: "",
			}
		},

		created() {
			this.getClasses();
		},



		methods: {
			async getClasses() {
				try {
					const response = await axios.get("Getting_classe");
					this.classes = response.data.actif;
					for (var i = response.data.actif.length - 1; i >= 0; i--) {
						this.classes[i] = response.data.actif[i].classe_fullname+' '+response.data.actif[i].classe_level;
					}
					console.log(this.classes);
				} 
				catch (error) {
					console.log(error);
				}
			},

			async Registration() {
				try{
					const response =  await axios.post("Create_student", {
						etudiant_email_adress: this.etudiant_email_adress,
						etudiant_firstname: 	this.etudiant_firstname,
						etudiant_lastname: this.etudiant_lastname,
						etudiant_contact1:this.etudiant_contact1,
						etudiant_contact2: this.etudiant_contact2,
						classe_etudiant: this.classe_etudiant,
						etudiant_privileges: this.etudiant_privileges,
					});
					(this.etudiant_email_adress = this.etudiant_email_adress),
					(this.etudiant_firstname = this.etudiant_firstname),
					(this.etudiant_lastname = this.etudiant_lastname),
					(this.etudiant_contact1 = this.etudiant_contact1),
					(this.etudiant_contact2 = this.etudiant_contact2),
					(this.classe_etudiant = this.classe_etudiant),
					(this.etudiant_privileges = this.etudiant_privileges),

					console.log(response.data);
					if (response.data.error === true) {
						Swal.fire({
							backdrop:true, 
							allowOutsideClick: false,
							confirmButtonText: "Je comprend !",
							icon: 'error',
							title: 'Failed !',
							text: "Erreur survenue durant l'enregistrement de l'étudiant "+this.etudiant_lastname+" "+this.etudiant_firstname,
							timer: 15000,
						})
						this.msg_etudiant_email_adress = response.data.msg.etudiant_email_adress;
						this.msg_etudiant_firstname = response.data.msg.etudiant_firstname;
						this.msg_etudiant_lastname = response.data.msg.etudiant_lastname;
						this.msg_etudiant_contact1 = response.data.msg.etudiant_contact1;
						this.msg_etudiant_contact2 = response.data.msg.etudiant_contact2;
						this.msg_classe_etudiant = response.data.msg.classe_etudiant
					}
					else{
						Swal.fire({
							backdrop:true, 
							allowOutsideClick: false,
							confirmButtonText: "Je comprend !",
							icon: 'success',
							title: 'Félicitations !',
							text: "l'enregistrement de l'étudiant "+this.etudiant_lastname+" "+this.etudiant_firstname+" est un succès !",
							confirmButtonText: 'Continuer',
						}).then((result) => {
							if (result.isConfirmed) {
								this.$router.push("/etudiants/create-account");
							}
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