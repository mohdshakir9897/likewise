//program of if else
#include <iostream>
using namespace std;
 
 //start of main function
 int main()
 {
     float i=0,total=500;
     float per=0;
     int ans;

     do
     {
     //taking input from user
     cout<<"\n please enter your marks";
     cin>>i;
     //caclulating per
     per=((i/total)*100);

     //start of if
     if(per<40)
     cout<<"fail";

     else if((per>=40) && (per<60))
     cout<<"\n passed with second devision"<<endl;
     else
   cout<<"\nfirst division"<<endl;
   
   cout<<"\n want to continue enter 1  ";
   cin>>ans;
   }while(ans==1);

     return 0;

 }//end of main function