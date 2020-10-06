import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CustomersService } from '../Services/ServiceCustomers';
import { Customers } from '../Data/Customers';
import { GenderService } from '../Services/ServiceGender';
import { Gender } from '../Data/Gender';
import { Location } from '@angular/common';

@Component({
  selector: 'app-profile-customer',
  templateUrl: './profile-customer.component.html',
  styleUrls: ['./profile-customer.component.css']
})
export class ProfileCustomerComponent implements OnInit {
  customer: Customers;
  NumIdentification: String;
  FKIdTypeDoc: number;
  FirstNameCustomer: String;
  SecondNameCustomer: String;
  LastNameCustomer: String;
  SecondLastNameCustomer:String
  Password: String;
  Mail: String;
  Address: String;
  AddressEntry: String;
  NumberPhone: String;
  IdGender: number;
  Status = 'M';
  FKIdUser = 1;
  FKIdGender: number;
  name: String;
  InputsDisabled = true;

  Genders:Gender[];
  constructor(private router: Router, private cusotmerservice: CustomersService, private gender:GenderService,private location: Location) { }

  ngOnInit() {
    var sesion = localStorage.getItem('IdSesion');
    if (!sesion) {
      this.router.navigate(['./']);
    }
    let numIden = localStorage.getItem('IdSesion');
    let TypeId = localStorage.getItem('TypeIdSesion');
    numIden = numIden.replace('"','');
    numIden = numIden.replace('"','');
    TypeId = TypeId.replace('"','');
    TypeId = TypeId.replace('"','');
    
    this.cusotmerservice.getCustomerLogin(numIden,Number(TypeId),"0").subscribe(respuesta => {
      this.customer = respuesta;

      this.NumIdentification = this.customer.NumIdentification;
      this.FKIdTypeDoc = this.customer.FKIdTypeDoc;
      this.FirstNameCustomer = this.customer.FirstNameCustomer;
      this.SecondNameCustomer = this.customer.SecondNameCustomer;
      this.LastNameCustomer = this.customer.LastNameCustomer;
      this.SecondLastNameCustomer = this.customer.SecondLastNameCustomer;
      this.Password = this.customer.Password;
      this.Mail = this.customer.Mail;
      this.Address = this.customer.Address;
      this.AddressEntry = this.customer.AddressEntry;
      this.NumberPhone = this.customer.NumberPhone;
      this.IdGender = this.customer.FKIdGender;
      this.FKIdGender = this.customer.FKIdGender;
      this.name = this.customer.name;

      

    }); 
    this.gender.getGenders()
      .subscribe(respuesta => this.Genders = respuesta);
  }
  ActivarInputs(){
    this.InputsDisabled = false;
  }
  goBack(): void {
    this.location.back();
  }

  UpdateChanges(): void {
    this.InputsDisabled = true;
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
    this.cusotmerservice.updateCustomer(Datapost)
      .subscribe(() => this.goBack());
  }
}
