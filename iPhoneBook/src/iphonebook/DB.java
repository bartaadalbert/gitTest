
package iphonebook;

import java.sql.Connection;
import java.sql.DatabaseMetaData;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author adalbertbarta
 */
public class DB {
    
    final String JDBC_DRIVER="org.apache.derby.jdbc.EmbeddedDriver";
     final String URL="jdbc:derby:newmyDB;create=true";
     final String USER_NAME="adalbertbarta";
     final String PASSWORD="1234mate";
     Connection conn=null ;
     Statement createStmt=null;
     ResultSet rs=null;
     DatabaseMetaData dm=null;
     
     ResultSetMetaData rsmd=null;
     
     public DB(){
        
         try {
             conn = DriverManager.getConnection(URL);
             System.out.println("A hid letrejott!!!");
         } catch (SQLException ex) {
             System.out.println(""+ex);
             System.out.println("Valami baj van a connectionnel");
         }
          
         if(conn !=null){
             
                try {
                    createStmt=  conn.createStatement();
                    System.out.println("A statement letrejott!!!");
                } catch (SQLException ex) {
                    System.out.println(""+ ex);
                    System.out.println("Valami baj van a statementtel!");
                }
         }
         
            try {
                
                 dm =conn.getMetaData();
                 System.out.println("Megvan a metadata");
            } catch (SQLException ex) {
                System.out.println(""+ ex);
                System.out.println("Valami baj van a metadataval!");
            }
            
            try {
                
                 rs= dm.getTables(null, "APP","CONTACT", null);
                 String sql="create table contacts(id INT not null primary key GENERATED ALWAYS AS IDENTITY(START WITH 1, INCREMENT BY 1) ,"
                         + "lastName varchar (20),firstName varchar(20), email varchar(30)) ";
                if(!rs.next()){
                    System.out.println("Sikerult az adatbazas tabolozaese!!!");
                    createStmt.execute(sql);
                
                }
            } catch (SQLException ex) {
                System.out.println(""+ ex);
                System.out.println("Valami baj van a createstatementtel resultset!");
            }
         
            
            
            
            
         }
         
//         public void userAdd(String name, String address){
//         try {
//             String sql="insert into Users values(?,?)";
//             //String sql="insert into Users values('"+name+"','"+address+"'))";
//             //createStmt.execute(sql);
//              //preparedStatement=null;
//              
//           PreparedStatement  preparedStatement =  conn.prepareStatement(sql);
//             
//             preparedStatement.setString(1, name);
//             preparedStatement.setString(2, address);
//             preparedStatement.execute();
//             System.out.println("Sikerult az adatokat bemasolni!!! hurra");
//         } catch (SQLException ex) {
//             System.out.println("Nem sikerult beletenni az adatokat!!! ");
//             System.out.println(""+ex);
//         }
         
         //}
     
   public void contactsAdd(Person person){
         try {
             String sql="insert into contacts (lastName, firstName, email) values(?,?,?)";
           
           PreparedStatement  preparedStatement =  conn.prepareStatement(sql);
             //preparedStatement.setString(0, id);
             preparedStatement.setString(1, person.getLastName() );
             preparedStatement.setString(2, person.getFirstName());
             preparedStatement.setString(3, person.getEmail());
             preparedStatement.execute();
             System.out.println("Sikerult az adatokat bemasolni!!! hurra");
         } catch (SQLException ex) {
             System.out.println("Nem sikerult beletenni az adatokat!!! ");
             System.out.println(""+ex);
         }
         
         }
   
     public void updatecontactsAdd(Person person){
         try {
             String sql="update contacts set lastName=?, firstName=?, email=? where id = ?";
           
           PreparedStatement  preparedStatement =  conn.prepareStatement(sql);
             //preparedStatement.setString(0, id);
             preparedStatement.setString(1, person.getLastName() );
             preparedStatement.setString(2, person.getFirstName());
             preparedStatement.setString(3, person.getEmail());
             preparedStatement.setInt(4, Integer.parseInt(person.getId()));
             preparedStatement.execute();
             System.out.println("Sikerult az adatokat atirni!!! hurra");
         } catch (SQLException ex) {
             System.out.println("Nem sikerult atirni az adatokat!!! ");
             System.out.println(""+ex);
         }
         
         }
     
   public ArrayList<Person> getAllUsers(){
     String sql="select * from contacts";
     ArrayList<Person> person= null;
     
         try {
             person=new ArrayList<>();
             ResultSet rs= createStmt.executeQuery(sql);
             while(rs.next()){
                 Person pn=new Person(rs.getInt("id"), rs.getString("lastName"),rs.getString("firstName"),rs.getString("email"));
                 person.add(pn);
                 //sSystem.out.println(name+" | "+address);
                 //System.out.println("A userek kiolvasasa megtortent!!!");
             }
         } catch (SQLException ex) {
             System.out.println(""+ ex);
             System.out.println("Nem sikerult a witeboard lekerdezes");
         }
    
    return person;
}          
     
 public void remuveContact(Person person){
     String sql="delete from contacts  where id = ?";
        try {   
            PreparedStatement  preparedStatement =  conn.prepareStatement(sql);
            preparedStatement.setInt(1, Integer.parseInt(person.getId()));
             preparedStatement.execute();
             System.out.println("Sikerult az adatokat torolni az adatbazisbol!!! hurra");
            
        } catch (SQLException ex) {
            System.out.println("Nem sikerult torlni az adatbazisbol!!!");
        }
 
 }    
     
}
