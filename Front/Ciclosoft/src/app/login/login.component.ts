import { Component, OnInit } from '@angular/core';
import { TipoDocumentoService } from '../Services/ServiceTypeDoc';
import { CustomersService } from '../Services/ServiceCustomers';
import { Typedocument } from '../Data/TypeDocument';
import { Customers } from '../Data/Customers';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  tiposDocumento: Typedocument[];
  RespuestaLogin: Customers;

  documento: String;
  tipodocumento: number;
  pass: String;
  constructor(private tipoDocumentoService: TipoDocumentoService, private CustomerLogin: CustomersService, private router: Router) { }
  // En el metodo onInit enviamos peticion para los tipos de documentos
  ngOnInit() {
    this.tipoDocumentoService.getTiposDocumento()
      .subscribe(respuesta => this.tiposDocumento = respuesta);
  }

  // metodo asociado al boton del login para consumir servicio con el que validamos el usuario
  ValidarUsuario() {
    this.CustomerLogin.getCustomerLogin(this.documento, this.tipodocumento, this.pass)
      .subscribe(respuesta => {
        this.RespuestaLogin = respuesta;

        if(this.RespuestaLogin.IdResponse != 0){
          alert("Error: " + this.RespuestaLogin.Response);
        }else{
          localStorage.setItem('IdSesion',JSON.stringify(this.RespuestaLogin.NumIdentification));
          localStorage.setItem('TypeIdSesion',JSON.stringify(this.RespuestaLogin.FKIdTypeDoc));
          this.router.navigate(['/']);
        }
      });
  }

}
