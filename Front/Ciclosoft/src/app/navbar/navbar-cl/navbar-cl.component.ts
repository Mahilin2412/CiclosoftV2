import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-navbar-cl',
  templateUrl: './navbar-cl.component.html',
  styleUrls: ['./navbar-cl.component.css']
})
export class NavbarCLComponent implements OnInit {

  constructor(private router: Router, private location: Location) { }

  ngOnInit() {
  }
  LogOut(){
    localStorage.clear();
    this.router.navigateByUrl('/');
  }
}
