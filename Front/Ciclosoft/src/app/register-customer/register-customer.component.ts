import { Component, OnInit } from '@angular/core';
import { TipoDocumentoService } from '../Services/ServiceTypeDoc';
import { CustomersService } from '../Services/ServiceCustomers';
import { GenderService } from '../Services/ServiceGender';
import { Typedocument } from '../Data/TypeDocument'; 
import { Gender } from '../Data/Gender'; 
import { Customers } from '../Data/Customers'; 
import { Router } from '@angular/router';


@Component({
  selector: 'app-register-customer',
  templateUrl: './register-customer.component.html',
  styleUrls: ['./register-customer.component.css']
})
export class RegisterCustomerComponent implements OnInit {
  tiposDocumento: Typedocument[];
  Genders: Gender[];
  NewCustomer:Customers; //respuesta servicio post
    NumIdentification: String;
    FirstNameCustomer: String;
    SecondNameCustomer: String = "";
    LastNameCustomer: String;
    SecondLastNameCustomer:String = "";
    Password: String;
    PasswordConf: String; // no pertenece al modelo de datos
    Mail: String;
    Address: String;
    AddressEntry: String;
    NumberPhone: String;
    FKIdTypeDoc: number;
    FKIdUser =1; // Por defecto el usuario que crea los clientes es un usuario dummy interno. 
    Status ='I'; // Como es para el metodo de Insert se pasa el estado (I)nsertado
    UpdateTimestamp: Date;
    FKIdGender: number;
    BolPass = false;
  constructor(private tipoDocumentoService: TipoDocumentoService, private customersService: CustomersService, private gender: GenderService, private router: Router) { }

  
  ngOnInit() {
    this.tipoDocumentoService.getTiposDocumento()
        .subscribe(respuesta=> this.tiposDocumento= respuesta);

    this.gender.getGenders()
      .subscribe(respuesta => this.Genders = respuesta);
  }
  GuardarCliente(){
    let Datapost = {
      NumIdentification: this.NumIdentification,
      FirstNameCustomer: this.FirstNameCustomer,
      SecondNameCustomer: this.SecondNameCustomer,
      LastNameCustomer: this.LastNameCustomer,
      SecondLastNameCustomer: this.SecondLastNameCustomer,
      Password: this.Password,
      Mail: this.Mail,
      Address: this.Address,
      AddressEntry: this.AddressEntry,
      NumberPhone: this.NumberPhone,
      FKIdTypeDoc: this.FKIdTypeDoc,
      FKIdUser: this.FKIdUser,
      Status: this.Status,
      UpdateTimestamp: new Date(),
      FKIdGender: this.FKIdGender,
      name: "",
      IdResponse: 0,
      Response: ""
    }
    console.log(Datapost);
    if(!Datapost){ return; }
    this.customersService.postCustomer(Datapost)
    .subscribe(result => {
      this.NewCustomer = result;
      
      if (this.NewCustomer.IdResponse != 0){
        alert("Error: " + this.NewCustomer.Response);
        return false;
      }else{
        alert("Ok: " + this.NewCustomer.Response);
        this.router.navigate(['./login']);
        return true;
      }
    });

   
  }
}
