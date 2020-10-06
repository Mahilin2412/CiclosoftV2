import { Component } from '@angular/core';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent {
  Logged = this.ValidaSesion();
  constructor() { }

  ValidaSesion():boolean {
    var sesion = localStorage.getItem('IdSesion');
    if (sesion) {
      return true;
      console.log("True");
    } else {
      return false;
      console.log("False");
    }
  }

}
