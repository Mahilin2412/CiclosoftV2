import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { UpdatePass } from '../Data/Updatepassword';
import { PasswordService } from '../Services/ServiceUpdatePass';
import { Location } from '@angular/common';

@Component({
  selector: 'app-update-password',
  templateUrl: './update-password.component.html',
  styleUrls: ['./update-password.component.css']
})
export class UpdatePasswordComponent implements OnInit {
  password: String; //contraseña actual
  NewPassword:String; //contraseña nueva
  ConfirmPass:String; //confitmar contraseña
  respuestaService: UpdatePass;
  constructor(private router: Router, private passwordserv:PasswordService, private location: Location) { }

  ngOnInit() {
    var sesion = localStorage.getItem('IdSesion');
    if (!sesion) {
      this.router.navigate(['./']);
    }
  }
  goBack(): void {
    //this.location.back();
  }
  updatePassword(){
    let numIden = localStorage.getItem('IdSesion');
    let TypeId = localStorage.getItem('TypeIdSesion');
    numIden = numIden.replace('"','');
    numIden = numIden.replace('"','');
    TypeId = TypeId.replace('"','');
    TypeId = TypeId.replace('"','');

    let Datapost = {
      Passwordold: this.password,
      Password: this.NewPassword,
      NumidenTification: numIden,
      FKIdTypeDoc: Number(TypeId),
      IdResponse: 0,
      Response:""
    }
    this.passwordserv.updatePassword(Datapost).subscribe(result =>{
      this.respuestaService = result;

      if (this.respuestaService.IdResponse != 0){
        alert(this.respuestaService.Response);
        return false;
      }else{
        alert("Ok: " + this.respuestaService.Response);
        localStorage.clear();
        this.router.navigateByUrl('/login');
        return true;
      }
    })
  }

}
