import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable, of } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';

import { UpdatePass } from '../Data/Updatepassword';

@Injectable({ providedIn: 'root' })
export class PasswordService {


 private resourceUrl = '/servicios/services/UpdatePass.php';  // URL to web api

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

  updatePassword(updateP: UpdatePass): Observable<any> {
    return this.http.put(this.resourceUrl, updateP, this.httpOptions).pipe(
      tap(_ => this.log(`updated password id=${updateP.NumidenTification}`)),
      catchError(this.handleError<any>('update password'))
    );
  }
  
}