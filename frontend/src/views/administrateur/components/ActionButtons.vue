<template>
    <div class="action-buttons">
        <v-row justify="space-around">
            <v-col cols="auto">
                <v-dialog transition="dialog-bottom-transition" max-width="800" >
                    <template v-slot:activator="{ on, attrs }">
                        <Tooltip :tooltipText="'Consulter ces données'">
                            <button class="" v-bind="attrs" v-on="on"  @click="handleAction('view')">
                                <i class="fa fa-eye"></i>
                            </button>
                        </Tooltip>
                    </template>

                    <template v-slot:default="dialog">
                        <v-card>
                            <v-toolbar color="primary" class="text-dark" dark >
                                <b>
                                    Informations de : <span class="text-uppercase ml-4" id="msg_user_firstname"></span>
                                </b>
                            </v-toolbar>
                            <v-card-text>
                                <v-row class="mt-4">
                                    <v-col cols="12" class="container-fluid">
                                        <span class="text-h5 pa-7">Matricule : </span>
                                        <span class="text-h6 pa-5" id="msg_user_matricule"></span>
                                    </v-col>
                                    <v-col cols="12">
                                        <span class="text-h5 pa-7">Noms : </span>
                                        <span class="text-h6 pa-14" id="msg_user_lastname"></span>
                                    </v-col>
                                    <v-col cols="12">
                                        <span class="text-h5 pa-7 col-md-3">Email : </span>
                                        <span class="text-h6 pa-5 ml-10" id="msg_user_email"></span>
                                    </v-col>
                                    <v-col cols="12">
                                        <span class="text-h5 pa-7">Contact : </span>
                                        <span class="text-h6 pa-7" id="msg_user_contact"></span>
                                    </v-col>
                                    <v-col cols="12">
                                        <span class="text-h5 pa-7">Filière : </span>
                                        <span class="text-h6 pa-5 ml-7" id="msg_user_filiere"></span>
                                    </v-col>
                                    <v-col cols="12">
                                        <span class="text-h5 pa-7 col-md-3">Spécialité : </span>
                                        <span class="text-h6 pa-2 " id="msg_user_speciality"></span>, 
                                        <span class="text-h5 pa-7 col-md-3">Niveau : </span>
                                        <span class="text-h6 pa-2 " id="msg_user_niveau"></span>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                            <v-card-actions class="justify-end mt-5">
                                <v-btn text @click="dialog.value = false">Fermer</v-btn>
                            </v-card-actions>
                        </v-card>
                    </template>
                </v-dialog>

                <Tooltip :tooltipText="'Modifier ces données'"> 
                    <button class="btn btn-outline-primary text-primary ml-4" @click="handleAction('edit')">
                        <i class="fa fa-edit"></i>
                    </button>
                </Tooltip>
                <Tooltip :tooltipText="'Supprimer ces données'">
                    <button class="btn btn-outline text-danger" @click="handleAction('delete')">
                        <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                    </button>
                </Tooltip>
            </v-col>
        </v-row>
    </div>
</template>


<script>
    import Tooltip from "../../../components/Tooltip.vue";
    import Swal from 'sweetalert2'
    import axios from "axios";

    let msg_user_matricule;     
    let msg_user_firstname;
    let msg_user_lastname;
    let msg_user_email;
    let msg_user_contact;
    let msg_user_filiere;
    let msg_user_speciality;
    let msg_user_niveau;

    export default {
        name: "ActionButtons",
        components: {
            Tooltip,
        },
        data(){
            return {
                msg_user_matricule: "",     
                msg_user_firstname: "",
                msg_user_lastname: "",
                msg_user_contact: "",
                msg_user_filiere: "",
                msg_user_speciality: "",
                msg_user_niveau: "",
            }
        },
        methods: {
            handleAction(actionName) {
                console.log(this.data)
                if (actionName == 'delete') {
                    Swal.fire({
                        title: 'Supprimer ?',
                        text: "Supprimer  l\'administrateur "+this.data.admin_lastname+" "+this.data.admin_firstname,
                        icon: 'warning',
                        backdrop:true, 
                        allowOutsideClick: false,
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: 'Continue',
                        denyButtonText: `Annuler`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            try {
                                axios.get(`UpdateUserEtat/`+this.data.id_admin);
                                Swal.fire({
                                    backdrop:true, 
                                    allowOutsideClick: false,
                                    timer: 5000,
                                    icon : 'success',
                                    title : 'Félicitations !',
                                    confirmButtonText: 'Continuer',
                                    text: 'L \'administrateur '+this.data.admin_lastname+" "+this.data.admin_firstname+' a été supprimé .',
                                });
                            } 
                            catch (error) {
                                console.log(error);
                            }
                            this.$router.push("/personnel/Nouveau")
                        }
                        else if (result.isDenied) {
                            Swal.fire({
                                backdrop:true, 
                                allowOutsideClick: false,
                                timer: 15000,
                                icon : 'error',
                                title : 'erreur !',
                                confirmButtonText: 'Continuer',
                                text: 'Impossibilité de supprimer l\'administrateur '+this.data.admin_lastname+" "+this.data.admin_firstname+'.',
                            });
                        }
                    })
                }
                else if(actionName == 'edit'){
                    console.log('modif en cours')
                    console.log(this.data)
                }
                else{
                    console.log('lecture en cours');
                    if (this.data.user_contact2 == '') {
                        document.getElementById("msg_user_contact").innerHTML = msg_user_contact = this.data.user_contact1;
                    }else{
                        document.getElementById("msg_user_contact").innerHTML = msg_user_contact = this.data.user_contact1+' / '+this.data.user_contact1;
                        console.log(msg_user_contact)
                    }
                    document.getElementById("msg_user_matricule").innerHTML = msg_user_matricule = this.data.user_matricule;
                    document.getElementById("msg_user_firstname").innerHTML = msg_user_lastname = this.data.user_lastname+" "+this.data.user_firstname;
                    document.getElementById("msg_user_lastname").innerHTML = msg_user_lastname = this.data.user_lastname+" "+this.data.user_firstname;
                    document.getElementById("msg_user_email").innerHTML = msg_user_email = this.data.user_email;
                    document.getElementById("msg_user_filiere").innerHTML = msg_user_filiere = this.data.user_filiere;
                    document.getElementById("msg_user_speciality").innerHTML = msg_user_speciality = this.data.user_speciality;
                    document.getElementById("msg_user_niveau").innerHTML = msg_user_niveau = this.data.user_niveau;
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
</style>