<template>
    <div class="action-buttons">
        <v-row justify="space-around">
            <v-col cols="auto" class="container">

                <v-dialog v-model="dialog" width="800" >
                    <template v-slot:activator="{ on, attrs }">
                        <Tooltip :tooltipText="'Consulter'">
                            <button class="" v-bind="attrs" v-on="on" open-on-focus="true" @click="handleAction('view')">
                                <i class="fa fa-eye"></i>
                            </button>
                        </Tooltip>
                    </template>
                    <v-card>
                        <v-card-title class="text-h5 grey lighten-2">
                            Informations : <span class="mx-4">{{msg_admin_fullname}}</span>
                        </v-card-title>
                        <v-divider></v-divider>

                        <v-card-text class="mt-3">
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Matricule : <span class="mx-4">{{msg_admin_matricule}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Username : <span class="mx-2">{{msg_admin_username}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Email : <span class="mx-10">{{msg_admin_email}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Password : <span class="mx-3">{{msg_admin_password}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Firstname : <span class="mx-3">{{msg_admin_firstname}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Lastname : <span class="mx-4">{{msg_admin_lastname}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Tel Orange : <span class="mx-2">{{msg_admin_contact1}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Tel MTN : <span class="mx-7">{{msg_admin_contact2}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Statut : <span class="mx-10">{{msg_admin_statut}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Privilèges : <span class="mx-4">{{msg_admin_privileges}}</span>
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col md="7" cols="12">
                                    <span class="float-Start">
                                        Create as : <span class="mx-4">{{msg_admin_create_as}}</span>
                                    </span>
                                </v-col>
                                <v-col md="5" cols="12">
                                    <span class="float-start">
                                        Update as : <span class="mx-4">{{msg_admin_update_as}}</span>
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
                        <Tooltip :tooltipText="'Consulter'">
                            <button class="btn btn-outline-primary text-primary ml-4"  v-bind="attrs" v-on="on" open-on-focus="true" @click="handleAction('edit')">
                                <i class="fa fa-edit"></i>
                            </button>
                        </Tooltip>
                    </template>
                    <v-form  @submit.prevent="Upgrations" >
                        <v-card-text>
                            <v-stepper v-model="e1">
                                <v-card-title class="text-h5 grey lighten-2">
                                    Modification : <span class="mx-4">{{msg_admin_fullname}}</span>
                                </v-card-title>
                                <v-divider md="6" cols="6"></v-divider>
                                <v-stepper-header class="">
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
                                        <v-card color="grey lighten-1"  height="250px">
                                            <v-row>
                                                <v-col md="6" cols="12" >
                                                    <span class="text-danger mx-2 mb-2">{{update_admin_username}}</span>
                                                    <span class="invisible">.</span>
                                                    <v-text-field 
                                                        :prepend-inner-icon="icons.mdiAccountLockOutline"
                                                        v-model="admin_username"
                                                        outlined
                                                        autocomplete="off"
                                                        label="Username"
                                                        placeholder="Nanyang Brice........"
                                                        hide-details
                                                        class="mb-3">
                                                    </v-text-field>
                                                </v-col>

                                                <v-col md="6" cols="12" >
                                                    <span class="invisible">.</span>
                                                    <span class="text-danger">{{msg_admin_username}}</span>
                                                    <v-text-field
                                                        :prepend-inner-icon="icons.mdiEmailCheckOutline"
                                                        v-model="admin_email"
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
                                                    <span class="invisible">.</span>
                                                    <span class="text-danger">{{msg_admin_password}}</span>
                                                    <v-text-field
                                                        class="mb-3"
                                                        :prepend-inner-icon="icons.mdiLockAlertOutline"
                                                        v-model="admin_password"
                                                        outlined
                                                        autocomplete="off"
                                                        :type="isPasswordVisible1 ? 'text' : 'password'"
                                                        label="Password"
                                                        placeholder="············"
                                                        :append-icon="isPasswordVisible1 ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                                                        hide-details
                                                        @click:append="isPasswordVisible1 = !isPasswordVisible1">
                                                    </v-text-field>
                                                </v-col>

                                                <v-col md="6" cols="12" >
                                                    <span class="invisible">.</span>
                                                    <span class="text-danger">{{msg_admin_password}}</span>
                                                    <v-text-field
                                                        class="mb-3"
                                                        :prepend-inner-icon="icons.mdiLockAlertOutline"
                                                        v-model="admin_password"
                                                        outlined
                                                        autocomplete="off"
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
                                        <v-card color="grey lighten-1" height="250px" >
                                            <v-row>
                                                <v-col md="6" cols="12" >
                                                    <span class="invisible">.</span>
                                                    <span class="text-danger">{{msg_admin_firstname}}</span>
                                                    <v-text-field 
                                                        :prepend-inner-icon="icons.mdiAccountOutline"
                                                        v-model="admin_firstname"
                                                        outlined
                                                        autocomplete="off"
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
                                                        autocomplete="off"
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
                                                        type="number" 
                                                        autocomplete="off"
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
                                                        type="number" 
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

                                        <v-btn color="primary" @click="e1 = 3">
                                            Continuer
                                        </v-btn>

                                        <v-btn @click="e1 = 1" >
                                            precedent
                                        </v-btn>
                                    </v-stepper-content>

                                    <v-stepper-content step="3">
                                        <v-card class="mb-12" color="grey lighten-1" height="150px">
                                            <v-row class="mt-2">
                                                <v-col md="12" cols="12" class="conatiner" >
                                                    <span class="invisible">.</span>
                                                    <span class="text-danger text-center">{{msg_admin_privileges}}</span>
                                                    <v-autocomplete
                                                        :prepend-inner-icon="icons.mdiAccountStarOutline"
                                                        v-model="admin_privileges"
                                                        autocomplete="off"
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
                </v-dialog>

                <Tooltip :tooltipText="'Supprimer'">
                    <button class="btn btn-outline text-danger" @click="handleAction('delete')">
                        <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                    </button>
                </Tooltip>
            </v-col>
        </v-row>
    </div>
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
    } from '@mdi/js';

    import { ref } from '@vue/composition-api';
    import Tooltip from "../../../../components/Tooltip.vue";
    import Swal from 'sweetalert2';
    import axios from "axios";
    import {useRouter} from "vue-router";

    export default {
        setup() {
            const isPasswordVisible = ref(false)
            const isPasswordVisible1 = ref(false)
            const admin_username = ref(false)
            const admin_email = ref(false)
            const admin_password = ref(false)
            const admin_firstname = ref(false)
            const admin_lastname = ref(false)
            const admin_contact1 = ref(false)
            const admin_contact2 = ref(false)

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
        name: "ActionButtons",
        components: {
            Tooltip,
        },
        data(){
            return {
                e1: 1,
                dialog: false,
                dialog1: false,
                msg_admin_fullname: "",     
                msg_admin_matricule: "",
                msg_admin_username: "",
                msg_admin_email: "",
                msg_admin_password: "",
                msg_admin_firstname: "",
                msg_admin_lastname: "",
                msg_admin_contact1: "",
                msg_admin_contact2: "",
                msg_admin_statut: "",
                msg_admin_privileges: "",
                msg_admin_create_as: "",
                msg_admin_update_as: "",

                update_admin_username: "",
                update_admin_email: "",
                update_admin_password: "",
                update_admin_firstname: "",
                update_admin_lastname: "",
                update_admin_contact1: "",
                update_admin_contact2: "",

                update : [],


                id_admin: "",     
                admin_username: "",     
                admin_email: "",
                admin_password: "",
                admin_firstname: "",
                admin_lastname: "",
                admin_contact1: "",
                admin_contact2: "",
                admin_privileges: "",

                privileges: [
                    'foo', 
                    'bar', 
                    'fizz', 
                    'buzz'
                ],
            }
        },
        methods: {
            handleAction(actionName) {
                if (actionName == 'delete') {
                    console.log('supression en cours')
                    Swal.fire({
                        title: 'Supprimer ?',
                        text: "Supprimer  l\'administrateur "+this.data.admin_lastname+" "+this.data.admin_firstname,
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
                                axios.get(`Desable_admin/`+this.data.id_admin);
                                Swal.fire({
                                    backdrop:true, 
                                    allowOutsideClick: false,
                                    timer: 5000,
                                    icon : 'success',
                                    title : 'Félicitations !',
                                    confirmButtonText: 'Continuer',
                                    text: 'L \'administrateur '+this.data.admin_lastname+" "+this.data.admin_firstname+' a été supprimé .',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        this.$router.go();
                                    }
                                });
                            } 
                            catch (error) {
                                console.log(error);
                            }
                           // this.$router.push("/administrateur/listing-account")
                        }
                        else if (result.isDenied) {
                            Swal.fire({
                                backdrop:true, 
                                allowOutsideClick: false,
                                timer: 15000,
                                icon : 'error',
                                title : 'Failed !',
                                confirmButtonText: 'Continuer',
                                text: 'Impossibilité de supprimer l\'administrateur '+this.data.admin_lastname+" "+this.data.admin_firstname+'.',
                            });
                        }
                    })
                }
                else if(actionName == 'edit'){
                    console.log('modif en cours')

                    //console.log(this.data)
                    this.msg_admin_fullname = this.data.admin_lastname + " " + this.data.admin_firstname;
                    this.admin_username = this.data.admin_username ;
                    this.admin_email = this.data.admin_email ;
                    this.admin_password = this.data.admin_password ;
                    this.admin_firstname = this.data.admin_firstname ;
                    this.admin_lastname = this.data.admin_lastname ;
                    this.admin_contact1 = this.data.admin_contact1 ;
                    this.admin_contact2 = this.data.admin_contact2 ;
                    this.update = this.data;
                    //console.log(this.update);
                }
                else{
                    console.log('lecture en cours');
                    console.log(this.data)
                    this.msg_admin_fullname = this.data.admin_lastname + " " + this.data.admin_firstname;
                    this.msg_admin_matricule = this.data.admin_matricule;
                    this.msg_admin_email = this.data.admin_email;
                    this.msg_admin_username = this.data.admin_username;
                    this.msg_admin_password = "****************";
                    this.msg_admin_firstname = this.data.admin_firstname;
                    this.msg_admin_lastname = this.data.admin_lastname;
                    this.msg_admin_contact1 = this.data.admin_contact1;
                    this.msg_admin_contact2 = this.data.admin_contact2;
                    this.msg_admin_statut = this.data.admin_statut;
                    this.msg_admin_privileges = "****************";
                    this.msg_admin_create_as = "****************";
                    this.msg_admin_update_as =  "****************";
                }
            },

            async Upgrations() {
                console.log(this.update);
                console.log(this.update.admin_contact2)

                try{
                    const response =  await axios.post("Update_admin", {
                        id_admin:       this.update.id_admin,
                        admin_username: this.admin_username,
                        admin_email:    this.admin_email,
                        admin_password: this.admin_password,
                        admin_firstname:this.admin_firstname,
                        admin_lastname: this.admin_lastname,
                        admin_contact1: this.admin_contact1,
                        admin_contact2: this.admin_contact2,
                        admin_privileges: this.admin_privileges,
                    });
                    (this.id_admin = this.update.id_admin),
                    (this.admin_username = this.update.admin_username),
                    (this.admin_email = this.update.admin_email),
                    (this.admin_password = this.update.admin_password),
                    (this.admin_firstname = this.update.admin_firstname),
                    (this.admin_lastname = this.update.admin_lastname),
                    (this.admin_contact1 = this.update.admin_contact1),
                    (this.admin_contact2 = this.update.admin_contact2),
                    console.log(response.data);

                    if (response.data.error == true) {
                        Swal.fire({
                            backdrop:true, 
                            allowOutsideClick: false,
                            confirmButtonText: "Je comprend !",
                            icon: 'error',
                            title: 'Failed !',
                            text: 'Erreur survenue durant la modification des données de l\'administrateur '+response.data.admin_lastname+' '+response.data.admin_firstname,
                            timer: 15000,
                        })
                        console.log(response.data.msg);
                        this.update_admin_username  =  response.data.msg.admin_username;
                        this.update_admin_email     =  response.data.msg.admin_email;
                        this.update_admin_password  =  response.data.msg.admin_password;
                        this.update_admin_firstname =  response.data.msg.admin_firstname;
                        this.update_admin_lastname  =  response.data.msg.admin_lastname;
                        this.update_admin_contact1  =  response.data.msg.admin_contact1;
                        this.update_admin_contact2  =  response.data.msg.admin_contact2;

                    } 
                    else {
                        Swal.fire({
                            backdrop:true, 
                            allowOutsideClick: false,
                            confirmButtonText: "Je comprend !",
                            icon: 'success',
                            title: 'Félicitations !',
                            text: ' l\'administrateur '+response.data.admin_lastname+' '+response.data.admin_firstname+' a bien été modifier',
                            timer: 15000,
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
    };
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