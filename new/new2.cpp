//program to reverse a number 1234  4321
#include <iostream>
using namespace std;
int main()
{
    int n=0,nn=0,rem;
    cout<<"\n enter the number";
    cin>>n;
    while(n>0)
    {
        rem=n%10;
        nn=nn*10+rem;
        n=n/10;

    }
    cout<<"\n new number is"<<nn<<endl;
    return 0;
}