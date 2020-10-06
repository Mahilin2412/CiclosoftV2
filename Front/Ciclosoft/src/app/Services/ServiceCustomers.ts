import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable, of } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';

import { Customers } from '../Data/Customers';

@Injectable({ providedIn: 'root' })
export class CustomersService {


 private resourceUrl = '/servicios/services/Customers/customersService.php';  // URL to web api

  httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };
    /**
   * Handle Http operation that failed.
   * Let the app continue.
   * @param operation - name of the operation that failed
   * @param result - optional value to return as the observable result
   */
  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {

      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }

  private log(message: string) {
    console.log(`Service: ${message}`);
  }
  constructor(
    private http: HttpClient) { }

  
  getCustomerLogin(NumId: String, TypeDoc: number, Pass: String): Observable<Customers> {
      let resourceUrlLocal = "";
      resourceUrlLocal = this.resourceUrl + "?NumIdentification="+ NumId +"&FKIdTypeDoc="+TypeDoc+"&Password="+Pass;
    return this.http.get<Customers>(resourceUrlLocal)
      .pipe(
        tap((loginResonse: Customers) => this.log(`fetched Login ${loginResonse.Mail}`)),
        catchError(this.handleError<Customers>('Error Login',))
      );
  }

  postCustomer(customer: Customers): Observable<Customers>{
    return this.http.post<Customers>(this.resourceUrl, customer, this.httpOptions)
      .pipe(
        tap((NewCustomer: Customers)=>this.log(`added Customer w/ id=${NewCustomer.Response}`)),
        catchError(this.handleError<Customers>('Error Add customer'))
      );

  }
  updateCustomer(customer: Customers): Observable<any> {
    return this.http.put(this.resourceUrl, customer, this.httpOptions).pipe(
      tap(_ => this.log(`updated customer id=${customer.NumIdentification}`)),
      catchError(this.handleError<any>('update Customer'))
    );
  }
  
}