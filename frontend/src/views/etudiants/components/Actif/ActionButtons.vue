<template>
    <div class="action-buttons">
        <v-row justify="space-around">
            <v-col cols="auto" class="container">
                <v-dialog v-model="dialog" width="700" >
                    <template v-slot:activator="{ on, attrs }">
                        <Tooltip :tooltipText="'Consulter '">
                            <button class="" v-bind="attrs" v-on="on" open-on-focus="true" @click="handleAction('view')">
                                <i class="fa fa-eye"></i>
                            </button>
                        </Tooltip>
                    </template>
                    <v-card>
                        <v-card-title class="text-h5 grey lighten-2">
                            Informations : <span class="mx-4">{{msg_etudiant_fullname}}</span>
                        </v-card-title>
                        <v-divider></v-divider>

                        <v-card-text class="mt-3">
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Matricule : <span class="mx-4">{{msg_etudiant_matricule}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Username : <span class="mx-2">{{msg_etudiant_username}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Email : <span class="mx-10">{{msg_etudiant_email_adress}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Password : <span class="mx-3">{{msg_etudiant_password}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Firstname : <span class="mx-3">{{msg_etudiant_firstname}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Lastname : <span class="mx-4">{{msg_etudiant_lastname}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Tel Orange : <span class="mx-2">{{msg_etudiant_contact1}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Tel MTN : <span class="mx-7">{{msg_etudiant_contact2}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Statut : <span class="mx-10">{{msg_etudiant_statut}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Privilèges : <span class="mx-4">{{msg_etudiant_privileges}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Create as : <span class="mx-4">{{msg_etudiant_create_as}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Update as : <span class="mx-4">{{msg_etudiant_update_as}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" elevation="7" block @click="dialog = false" >
                                Fermer
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-dialog v-model="dialog1" width="1100"  height="1000px">
                    <template v-slot:activator="{ on, attrs }">
                        <Tooltip :tooltipText="'Modifier'">
                            <button class="btn btn-outline-primary text-primary ml-4"  v-bind="attrs" v-on="on" open-on-focus="true" @click="handleAction('edit')">
                                <i class="fa fa-edit"></i>
                            </button>
                        </Tooltip>
                    </template>
                    <v-form  @submit.prevent="Upgrations" >
                        <v-card-text>
                            <v-stepper v-model="e1">
                                <v-card-title class="text-h5 grey lighten-2">
                                    Modification : <span class="mx-4">{{msg_etudiant_fullname}}</span>
                                </v-card-title>
                                <v-divider md="6" cols="6"></v-divider>
                                <v-stepper-header class="">
                                    <v-stepper-step :complete="e1 > 1" step="1" >
                                        Informations Principales
                                    </v-stepper-step>

                                    <v-divider></v-divider>

                                    <v-stepper-step :complete="e1 > 2" step="2" >
                                        Informations Secondaires
                                    </v-stepper-step>
                                </v-stepper-header>

                                <v-stepper-items>
                                    <v-stepper-content step="1">
                                        <v-card color="grey lighten-1"  height="250px">
                                            <v-row>
                                                <v-col md="6" cols="12" >
                                                    <span class="invisible">5</span>
                                                    <span class="text-danger">{{upadte_etudiant_firstname}}</span>
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
                                                    <span class="text-danger">{{upadte_etudiant_lastname}}</span>
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
                                                    <span class="text-danger">{{upadte_etudiant_contact1}}</span>
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
                                        <v-card color="grey lighten-1"  height="250px">
                                            <v-row class="mt-2">
                                                <v-col md="12" cols="12" >
                                                    <span class="text-danger">{{upadte_etudiant_email_adress}}</span>
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
                                                    <span class="text-danger">{{upadte_classe_etudiant}}</span>
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
                </v-dialog>

                <Tooltip :tooltipText="'Supprimer'">
                    <button class="btn btn-outline text-danger" @click="handleAction('delete')">
                        <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                    </button>
                </Tooltip>

                <Tooltip :tooltipText="'Imprimer rapport'">
                    <button class="btn btn-outline" @click="handleAction('print_report')">
                        <i class="fa fa-print" aria-hidden="true"></i>
                    </button>
                </Tooltip>

            </v-col>
        </v-row>
    </div>
</template>

<script>
    import { 
        mdiAccountLockOutline,  mdiEmailCheckOutline,  mdiEyeOutline, 
        mdiEyeOffOutline,  mdiLockAlertOutline, mdiAccountOutline, 
        mdiCellphoneSettings, mdiCloudUploadOutline,  mdiAccountStarOutline, 
    } from '@mdi/js';

    import { ref } from '@vue/composition-api';
    import Tooltip from "../../../../components/Tooltip.vue";
    import Swal from 'sweetalert2';
    import axios from "axios";
    import {useRouter} from "vue-router";

    export default{

        props: {
            accountData: {
                type: Object,
                default: () => {},
            },
        },
        name: "ActionButtons",
        components: {
            Tooltip,
        }, 

        setup() {
            const admin_username = ref(false)
            const admin_email = ref(false)
            const admin_password = ref(false)
            const admin_firstname = ref(false)
            const admin_lastname = ref(false)
            const admin_contact1 = ref(false)
            const admin_contact2 = ref(false)

            return {
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

        data(){
            return {
                e1: 1,
                dialog: false,
                dialog1: false,


                id_etudiant: "",     
                etudiant_firstname: "",
                etudiant_lastname: "",
                etudiant_contact1: "",
                etudiant_contact2: "",
                etudiant_email_adress: "",
                classe_etudiant: "",
                etudiant_privileges: "",

                msg_etudiant_fullname: "",     
                msg_etudiant_matricule: "",     
                msg_classe_etudiant: "",
                msg_etudiant_username: "",
                msg_etudiant_password: "",
                msg_etudiant_firstname: "",
                msg_etudiant_lastname: "",
                msg_etudiant_contact1: "",
                msg_etudiant_contact2: "",
                msg_etudiant_email_adress: "",
                msg_etudiant_privileges: "",
                msg_etudiant_statut: "",
                msg_etudiant_create_as: "",
                msg_etudiant_update_as: "",

                update : [],

                upadte_classe_etudiant: "",
                upadte_etudiant_email_adress: "",
                upadte_etudiant_firstname: "",
                upadte_etudiant_lastname: "",
                upadte_etudiant_contact1: "",
                upadte_etudiant_contact2: "",
                upadte_etudiant_privileges: "",

                privileges: [
                    'foo', 
                    'bar', 
                    'fizz', 
                    'buzz'
                ],

                classes: [],
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

            handleAction(actionName) {
                if (actionName == 'delete') {
                    console.log('supression en cours')
                    Swal.fire({
                        title: 'Supprimer ?',
                        text: "Supprimer  l\'étudiant "+this.data.etudiant_lastname+" "+this.data.etudiant_firstname,
                        icon: 'warning',
                        backdrop:true, 
                        allowOutsideClick: false,
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: 'Continuer',
                        denyButtonText: `Annuler`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            try {
                                axios.get(`Desable_student/`+this.data.id_etudiant);
                                Swal.fire({
                                    backdrop:true, 
                                    allowOutsideClick: false,
                                    timer: 5000,
                                    icon : 'success',
                                    title : 'Félicitations !',
                                    confirmButtonText: 'Continuer',
                                    text: 'L \'étudiant '+this.data.etudiant_lastname+" "+this.data.etudiant_firstname+' a bien été supprimé .',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        this.$router.go();
                                    }
                                });
                            } 
                            catch (error) {
                                console.log(error);
                            }
                        }
                        else if (result.isDenied) {
                            Swal.fire({
                                backdrop:true, 
                                allowOutsideClick: false,
                                timer: 15000,
                                icon : 'error',
                                title : 'Failed !',
                                confirmButtonText: 'Continuer',
                                text: 'Erreur survenue durant la suppression de l\'étudiant '+this.data.etudiant_lastname+" "+this.data.etudiant_firstname+'.',
                            });
                        }
                    })
                }

                else if(actionName == 'edit'){
                    console.log('modif en cours');
                    this.msg_etudiant_fullname  = this.data.etudiant_lastname + " " + this.data.etudiant_firstname;
                    this.etudiant_email_adress  = this.data.etudiant_email_adress ;
                    this.etudiant_firstname     = this.data.etudiant_firstname ;
                    this.etudiant_lastname      = this.data.etudiant_lastname ;
                    this.etudiant_contact1      = this.data.etudiant_contact1 ;
                    this.etudiant_contact2      = this.data.etudiant_contact2 ;
                    this.update = this.data;
                    console.log(this.update);
                }
                else{
                    console.log('lecture en cours');
                    console.log(this.data)
                    this.msg_etudiant_fullname      = this.data.etudiant_lastname + " " + this.data.etudiant_firstname;
                    this.msg_etudiant_matricule     = this.data.etudiant_matricule;
                    this.msg_etudiant_email_adress  = this.data.etudiant_email_adress;
                    this.msg_etudiant_username      = this.data.etudiant_username;
                    this.msg_etudiant_password      = "****************";
                    this.msg_etudiant_firstname     = this.data.etudiant_firstname;
                    this.msg_etudiant_lastname      = this.data.etudiant_lastname;
                    this.msg_etudiant_contact1      = '+237'+this.data.etudiant_contact1;
                    this.msg_etudiant_contact2      = '+237'+this.data.etudiant_contact2;
                    this.msg_etudiant_statut        = this.data.etudiant_statut;
                    this.msg_etudiant_privileges    = "****************";
                    this.msg_etudiant_create_as     = "****************";
                    this.msg_etudiant_update_as     =  "****************";
                }
            },

            async Upgrations() {
                try{
                    const response =  await axios.post("Update_student", {
                        id_etudiant:            this.id_etudiant,
                        etudiant_firstname:     this.etudiant_firstname,
                        etudiant_lastname:      this.etudiant_lastname,
                        etudiant_contact1:      this.etudiant_contact1,
                        etudiant_contact2:      this.etudiant_contact2,
                        etudiant_email_adress:  this.etudiant_email_adress,
                        classe_etudiant:        this.classe_etudiant,
                        etudiant_privileges:    this.etudiant_privileges,
                    });
                    (this.id_etudiant           = this.update.id_etudiant);
                    (this.etudiant_firstname    = this.update.etudiant_firstname);
                    (this.etudiant_lastname     = this.update.etudiant_lastname);
                    (this.etudiant_contact1     = this.update.etudiant_contact1);
                    (this.etudiant_contact2     = this.update.etudiant_contact2);
                    (this.etudiant_email_adress = this.update.etudiant_email_adress);
                    (this.classe_etudiant       = this.update.classe_etudiant);
                    (this.etudiant_privileges   = this.update.etudiant_privileges);

                   // console.log(response.data);
                    if (response.data.error == true) {
                        Swal.fire({
                            backdrop:true, 
                            allowOutsideClick: false,
                            confirmButtonText: "Je comprend !",
                            icon: 'error',
                            title: 'Failed !',
                            text: 'Erreur survenue durant la modification des données de l\'étudiant '+response.data.etudiant_lastname+' '+response.data.etudiant_firstname,
                        })
                        console.log(response.data.msg);
                        this.upadte_classe_etudiant         =  response.data.msg.classe_etudiant;
                        this.upadte_etudiant_email_adress   =  response.data.msg.etudiant_email_adress;
                        this.upadte_etudiant_firstname      =  response.data.msg.etudiant_firstname;
                        this.upadte_etudiant_lastname       =  response.data.msg.etudiant_lastname;
                        this.upadte_etudiant_contact1       =  response.data.msg.etudiant_contact1;
                        this.upadte_etudiant_contact2       =  response.data.msg.etudiant_contact2;
                        this.upadte_etudiant_privileges     =  response.data.msg.etudiant_privileges;
                    } 
                    else {
                        Swal.fire({
                            backdrop:true, 
                            allowOutsideClick: false,
                            confirmButtonText: "Je comprend !",
                            icon: 'success',
                            title: 'Félicitations !',
                            text: 'Les données de l\'étudiant '+response.data.etudiant_lastname+' '+response.data.etudiant_firstname+' ont bien été modifiées',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.$router.go();
                            }
                        });
                    }
                }
                catch (error) {
                    console.log(error);
                }
            }
        },

        props: {
            data: {
                type: Object,
                required: true,
            },
        },
    }

    /* fonction de contradiction des input number */
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
    .text-dark {
        color: #000 !important;
    }
    .text-primary {
      color: #007bff !important;
    }
    .invisible {
      visibility: hidden !important;
    }
</style>