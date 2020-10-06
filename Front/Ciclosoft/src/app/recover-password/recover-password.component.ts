import { Component, OnInit } from '@angular/core';
import { Typedocument } from '../Data/TypeDocument';
import { Customers } from '../Data/Customers';
import { TipoDocumentoService } from '../Services/ServiceTypeDoc';
import { ServiceRecoverPassword } from '../Services/ServiceRecoverPassword';

@Component({
  selector: 'app-recover-password',
  templateUrl: './recover-password.component.html',
  styleUrls: ['./recover-password.component.css']
})
export class RecoverPasswordComponent implements OnInit {
  tiposDocumento: Typedocument[];
  RespuestaLogin: Customers;

  documento: String;
  tipodocumento: number;
  pass: String;

  constructor(private tipoDocumentoService: TipoDocumentoService, private recoverPass: ServiceRecoverPassword) { }

  ngOnInit() {
    this.tipoDocumentoService.getTiposDocumento()
      .subscribe(respuesta => this.tiposDocumento = respuesta);
  }
  goBack(){}
  recuperaPass(){
    this.recoverPass.GetNewPass(this.documento,this.tipodocumento).subscribe(() => this.goBack());
  }
}
