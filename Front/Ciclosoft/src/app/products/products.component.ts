import { Component, OnInit, ViewChild } from '@angular/core';
import { PageEvent  } from '@angular/material/paginator';
import { ServiceProducts } from '../Services/ServiceProducts'
import { Products } from '../Data/Products';
import { VirtualTimeScheduler } from 'rxjs';
@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: ['./products.component.css']
})
export class ProductsComponent implements OnInit {
  ProductsFetched: Products[] = [];
  CantidadItems: number;
  page = 1;
  pageSlice: any;
  constructor(private serviceproducts: ServiceProducts) {
    this.ProductsFetched = new Array<Products>();
  }


  ngOnInit() {
    this.serviceproducts.getProducts()
      .subscribe(Respuesta =>{
        console.log(Respuesta);
        this.ProductsFetched = Respuesta
        this.CantidadItems = this.ProductsFetched.length;
      });
  }
}