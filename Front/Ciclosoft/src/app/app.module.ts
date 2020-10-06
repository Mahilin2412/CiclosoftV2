import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http'
import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';
import { FormsModule } from '@angular/forms';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations'; 
import { AlifeFileToBase64Module } from 'alife-file-to-base64';

/* COMPONENTES */
import { LoginComponent } from './login/login.component';
import { ProductsComponent } from './products/products.component';
import { NavbarSLComponent } from './navbar/navbar-sl/navbar-sl.component';
import { NavbarCLComponent } from './navbar/navbar-cl/navbar-cl.component';
import { NavbarComponent } from './navbar/navbar.component';
import { RegisterCustomerComponent } from './register-customer/register-customer.component';
import { CarouselComponent } from './carousel/carousel.component';
import { UpdatePasswordComponent } from './update-password/update-password.component';
import { RecoverPasswordComponent } from './recover-password/recover-password.component';
import { ProfileCustomerComponent } from './profile-customer/profile-customer.component';

/* ANGULAR MATERIAL */
import { MatIconModule } from '@angular/material/icon';
import { MatCardModule } from '@angular/material/card';
import { MatPaginatorModule } from '@angular/material/paginator';
import { NgxPaginationModule } from 'ngx-pagination';
import {MatButtonModule} from '@angular/material/button';
import {MatBadgeModule} from '@angular/material/badge';
import { AddProductsComponent } from './add-products/add-products.component';
import { EmployeeLoginComponent } from './employee-login/employee-login.component';


/**/
//import AccountCircleRoundedIcon from '@material-ui/icons/AccountCircleRounded'; validar el tema de los logos

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterCustomerComponent,
    ProductsComponent,
    NavbarSLComponent,
    NavbarCLComponent,
    NavbarComponent,
    ProfileCustomerComponent,
    CarouselComponent,
    UpdatePasswordComponent,
    RecoverPasswordComponent,
    AddProductsComponent,
    EmployeeLoginComponent,
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    AppRoutingModule,
    FormsModule,
    BrowserAnimationsModule,
    MatCardModule,
    MatIconModule,
    MatPaginatorModule,
    NgxPaginationModule,
    MatButtonModule,
    MatBadgeModule,
    AlifeFileToBase64Module
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
