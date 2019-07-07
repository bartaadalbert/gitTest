
package iphonebook;

//import java.awt.Image;
import com.itextpdf.text.Document;
import com.itextpdf.text.pdf.PdfWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.net.URL;
import java.util.Optional;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.beans.value.ObservableValue;
import javafx.beans.value.ChangeListener;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.geometry.Pos;
import javafx.scene.Node;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.ButtonType;
import javafx.scene.control.Label;
import javafx.scene.control.SplitPane;
import javafx.scene.control.TableCell;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.TreeItem;
import javafx.scene.control.TreeView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.control.cell.TextFieldTableCell;
import javafx.scene.image.ImageView;
import javafx.scene.layout.Pane;
import javafx.scene.layout.StackPane;
import javafx.scene.image.Image;
import static javafx.scene.input.KeyCode.F;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.VBox;
import javafx.util.Callback;

/**
 *
 * @author adalbertbarta
 */
public class ViewController implements Initializable {
    @FXML
    Label label;
    @FXML
    TableView table;
    @FXML
    TextField inputLastName;
    @FXML
    TextField inputFirstName;
    @FXML
    TextField inputEmail;
    @FXML
    Button send;
    @FXML
    StackPane menupane;
    @FXML
    Pane contactpane;
    @FXML
    Pane exportpane;
    @FXML
    TextField exporttextfield;
    @FXML
    Button exportbutton;
    @FXML
    Label exportlabel;
    @FXML
    AnchorPane anchorPane;
    @FXML
    SplitPane splitPane;
    @FXML
    Button alertButton;
    
    private final String Menu_Contacts="Contacts";
    private final String Menu_List="Show users";
    private final String Menu_Export="Export to pdf";
    private final String Menu_Exit="Logout";
    private final String Menu_M="Under menu";
    private final String COLNAME1="Vezeteknev";
    private final String COLNAME2="Keresztnev";
    private final String COLNAME3="email";
    private final String COLNAME4="Delete";
    String path="/Users/adalbertbarta/Downloads/images-3.png";
    DB db= new DB();

private final ObservableList<Person> data=  FXCollections.observableArrayList();
    
    @FXML
    private void handleButtonAction(ActionEvent event) {
        
        
    }
    
    @FXML
    public void addContact(ActionEvent event){
         String mail= inputEmail.getText();
         if(mail.length()>3 && mail.contains("@") && mail.contains(".") ){
          Person newPerson = new Person( inputLastName.getText(),inputFirstName.getText(),mail);
    data.add(newPerson);
    db.contactsAdd(newPerson);
    inputLastName.clear();
    inputFirstName.clear();
    inputEmail.clear();
    }else {alertka("Wrong email format");}
    }
    
    public void setTableDate(){
    TableColumn lastNameCol=new TableColumn(COLNAME1);
        lastNameCol.setMinWidth(100);
        lastNameCol.setCellFactory(TextFieldTableCell.forTableColumn());
        lastNameCol.setCellValueFactory(new PropertyValueFactory<Person, String>("lastName"));
        
        lastNameCol.setOnEditCommit(
                new EventHandler<TableColumn.CellEditEvent<Person, String>>() {
            @Override
            public void handle(TableColumn.CellEditEvent<Person, String> e ) {
                //throw new UnsupportedOperationException("Not supported yet."); 
               Person actualPerson=  (Person) e.getTableView().getItems().get(e.getTablePosition().getRow());
                       actualPerson.setLastName(e.getNewValue());
                       db.updatecontactsAdd(actualPerson);
            }
        }
        
        );
        
        
        TableColumn firstNameCol=new TableColumn(COLNAME2);
        firstNameCol.setMinWidth(100);
        firstNameCol.setCellFactory(TextFieldTableCell.forTableColumn());
        firstNameCol.setCellValueFactory(new PropertyValueFactory<Person, String>("firstName"));
        
        firstNameCol.setOnEditCommit(
                new EventHandler<TableColumn.CellEditEvent<Person, String>>() {
            @Override
            public void handle(TableColumn.CellEditEvent<Person, String> f) {
                //throw new UnsupportedOperationException("Not supported yet."); 
                Person actualPerson=  (Person) f.getTableView().getItems().get(f.getTablePosition().getRow());
                       actualPerson.setFirstName(f.getNewValue());
                       db.updatecontactsAdd(actualPerson);
            }
        }
        
        );
        
        TableColumn emailCol=new TableColumn(COLNAME3);
        emailCol.setMinWidth(200);
        emailCol.setCellFactory(TextFieldTableCell.forTableColumn());
        emailCol.setCellValueFactory(new PropertyValueFactory<Person, String>("email"));
        
        emailCol.setOnEditCommit(
                new EventHandler<TableColumn.CellEditEvent<Person, String>>() {
            @Override
            public void handle(TableColumn.CellEditEvent<Person, String> k) {
                //throw new UnsupportedOperationException("Not supported yet.");
                String kk =k.getNewValue();
                if(kk.length()>3 && kk.contains("@") && kk.contains(".")){
                  Person actualPerson=  (Person) k.getTableView().getItems().get(k.getTablePosition().getRow());
                       actualPerson.setEmail(k.getNewValue());
                       System.out.println(actualPerson.toString());
                       db.updatecontactsAdd(actualPerson);
                }else{
                alertka("Wrong email format");
                }
            }
        }
        
        );
        
        TableColumn deleteNameCol=new TableColumn(COLNAME4);
        deleteNameCol.setMinWidth(80);
        //deleteNameCol.setCellFactory(TextFieldTableCell.forTableColumn());
        //deleteNameCol.setCellValueFactory(new PropertyValueFactory<Person, String>("firstName"));
        
                           
        
        Callback<TableColumn<Person, String>, TableCell<Person, String>> cellFactory
                = new Callback <TableColumn<Person, String>, TableCell<Person, String>>()
                {
                    @Override
                        public TableCell call(final TableColumn<Person, String> param )
                        {
                            final TableCell<Person, String> cell = new TableCell<Person, String>()
                            {
                              
                               File f=new File(path);
                               Image image=new Image(f.toURI().toString());
                               ImageView ima=new ImageView(image);
                              final Button btn = new Button("Delete", ima);
                              //btn.setBackground();
                              
                              @Override
                              public void updateItem(String item, boolean emty){
                                  super.updateItem(item, emty);
                                  if(emty)
                                  {
                                      setGraphic(null); 
                                      setText(null);
                                  }  else //if(alertka())
                                  
                                  {
                                      btn.setOnAction((ActionEvent event ) ->
                                      
                                      {
                                          splitPane.setDisable(true);
                                          splitPane.setOpacity(0.4);
        
        Label label=new Label("Are you sure?");
        Button bi= new Button("OK");
        Button ci= new Button("Cencel");
        VBox vbox= new VBox(label,bi,ci);
        vbox.setAlignment(Pos.CENTER);
                                       
        anchorPane.getChildren().add(vbox);
        anchorPane.setTopAnchor(vbox, 300.0);
        anchorPane.setLeftAnchor(vbox, 300.0);
        anchorPane.setVisible(true);
        
                        bi.setOnAction(new EventHandler<ActionEvent>(){
            @Override
            public void handle(ActionEvent event){
                splitPane.setDisable(false);
                splitPane.setOpacity(1);
                vbox.setVisible(false);
                Person person=getTableView().getItems().get(getIndex());
                                          data.remove(person);
                                          db.remuveContact(person);
            }
        
        });
                        
                        ci.setOnAction(new EventHandler<ActionEvent>(){
            @Override
            public void handle(ActionEvent event){
                splitPane.setDisable(false);
                splitPane.setOpacity(1);
                vbox.setVisible(false);
          
            }
        
        });
                        
                        
        
//                                          splitPane.setDisable(true); splitPane.setOpacity(0.4);
//                                          Alert alert = 
//                                                    new Alert(AlertType.WARNING, 
//                                                            
//                                                        "Are you sure? If you delete this row you remove all data " + ".",
//                                                         ButtonType.OK, 
//                                                         ButtonType.CANCEL);
//                                            alert.setTitle("Date will be deleted");
//                                            Optional<ButtonType> result = alert.showAndWait();
//                                                if (result.get() == ButtonType.OK) {
//                                            splitPane.setDisable(false);
//                                             splitPane.setOpacity(1);
//                                          Person person=getTableView().getItems().get(getIndex());
//                                          data.remove(person);
//                                          db.remuveContact(person);
//                                                }else
//                                                {
//                                                    splitPane.setDisable(false);
//                                                     splitPane.setOpacity(1);
//                                                }
                                      });
                                      
                                      setGraphic(btn); 
                                      setText(null);
                                  }
                                  
                              }
                               
                            };
                            return cell;
                        }
                
                
                };
        
        deleteNameCol.setCellFactory(cellFactory);
        table.getColumns().addAll(lastNameCol, firstNameCol, emailCol,deleteNameCol);
        data.addAll(db.getAllUsers());
        table.setItems(data);
    }
    
    private void setMenuDate() {
         TreeItem<String> tIR1=new TreeItem<>("Menu");
         TreeView<String> tV=new TreeView<>(tIR1);
         tV.setShowRoot(false);
         
         TreeItem<String> nodeItemA=new TreeItem<>(Menu_Contacts);
         TreeItem<String> nodeItemB=new TreeItem<>(Menu_Exit);
         //nodeItemA.setExpanded(true);
         
         Node contactsNode= new ImageView(new Image(getClass().getResourceAsStream("/ios.png")));
         Node exportNode= new ImageView(new Image(getClass().getResourceAsStream("/export.jpg")));
         
         Node undermenuNode = new ImageView(new Image(getClass().getResourceAsStream("/undermenu.gif")));
         
         TreeItem<String> nodeItemA1=new TreeItem<>(Menu_List,contactsNode);
         TreeItem<String> nodeItemA2=new TreeItem<>(Menu_Export,exportNode);
         TreeItem<String> nodeItemA11=new TreeItem<>(Menu_M, undermenuNode);
         
         tIR1.getChildren().addAll(nodeItemA, nodeItemB);
         nodeItemA.getChildren().addAll(nodeItemA1,nodeItemA2);
         nodeItemA1.getChildren().addAll(nodeItemA11);
         
         menupane.getChildren().add(tV);
         tV.getSelectionModel().selectedItemProperty().addListener(new ChangeListener(){
             public void changed(ObservableValue observable, Object oldValue, Object newValue){
             TreeItem<String> selectedItem=(TreeItem<String>) newValue;
             String selectedMenu;
             selectedMenu=selectedItem.getValue();
                if(null != selectedMenu){
                    switch(selectedMenu){
                        case Menu_Contacts:
                            try{
                            selectedItem.setExpanded(true);
                            }catch(Exception ex){
                                
                            }break;
                            case Menu_List:
                                contactpane.setVisible(true);
                                exportpane.setVisible(false);
                            try{
                            selectedItem.setExpanded(true);
                            }catch(Exception ex){
                                
                            }break;
                        case Menu_Export:
                            exportpane.setVisible(true);
                            contactpane.setVisible(false);
                            break;
                        case Menu_Exit:
                            System.exit(0);
                            break;
                    }
                
                }
             
             }
         
         });
            
      
    }  
    
    @FXML
    public void exportList(ActionEvent event){
        String fileName= exporttextfield.getText();
        fileName= fileName.replaceAll("\\s+", "");
        if(fileName !=null && !fileName.equals("")){
       PdfGenerator pdfg= new PdfGenerator();
      pdfg.pdfGenerator(fileName, data);
        }else{
        alertka("You dont writ name for the document!!!");
        }
        
        exporttextfield.clear();
    }
    @FXML
    public void alertka(String a){
        splitPane.setDisable(true);
        splitPane.setOpacity(0.4);
        
        Label label=new Label(a);
        Button alertButton= new Button("OK");
        VBox vbox= new VBox(label,alertButton);
        vbox.setAlignment(Pos.CENTER);
        
        alertButton.setOnAction(new EventHandler<ActionEvent>(){
            @Override
            public void handle(ActionEvent event){
                splitPane.setDisable(false);
                splitPane.setOpacity(1);
                vbox.setVisible(false);
            }
        
        });
        
        anchorPane.getChildren().add(vbox);
        anchorPane.setTopAnchor(vbox, 300.0);
        anchorPane.setLeftAnchor(vbox, 300.0);
        anchorPane.setVisible(true);
        
        
    
    }
    

    
    @Override
    public void initialize(URL url, ResourceBundle rb) {
      setTableDate(); 
      setMenuDate();
      
  
      
    }    

    
    
}
