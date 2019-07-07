
package iphonebook;

import com.itextpdf.text.BaseColor;
import com.itextpdf.text.Chunk;
import com.itextpdf.text.Document;
import com.itextpdf.text.Element;
import com.itextpdf.text.FontFactory;
import com.itextpdf.text.Image;
import com.itextpdf.text.Paragraph;
import com.itextpdf.text.Phrase;
import com.itextpdf.text.pdf.BaseFont;
import com.itextpdf.text.pdf.GrayColor;
import com.itextpdf.text.pdf.PdfPCell;
import com.itextpdf.text.pdf.PdfPTable;
import com.itextpdf.text.pdf.PdfWriter;
import java.io.FileOutputStream;
import javafx.collections.ObservableList;

/**
 *
 * @author adalbertbarta
 */
public class PdfGenerator {
    
    public void pdfGenerator(String fileName, ObservableList<Person> data){
    Document d= new Document();
        try {
            PdfWriter.getInstance(d, new FileOutputStream(fileName +".pdf"));
            d.open();
            Image im=  Image.getInstance(getClass().getResource("/II.jpg"));
            im.setRotationDegrees(90);
            im.scaleToFit(300, 186);
            im.setAbsolutePosition(200f, 650f);
            d.add(im);
            //d.add(new Paragraph("\n\n\n\n\n\n\n\n\n\n\n"+ text, FontFactory.getFont("betutipus", BaseFont.IDENTITY_H, BaseFont.EMBEDDED)));
            
            float [] columWidth={2,3,3,4};
            PdfPTable table=new PdfPTable(columWidth);
            table.setWidthPercentage(100);
            PdfPCell cell= new PdfPCell(new Phrase("Kontaktok Listaja"));
            cell.setBackgroundColor(GrayColor.LIGHT_GRAY);
            cell.setHorizontalAlignment(Element.ALIGN_CENTER);
            cell.setColspan(4);
            table.addCell(cell);
            
            table.getDefaultCell().setBackgroundColor(new GrayColor(0.75f) );
            table.getDefaultCell().setHorizontalAlignment(Element.ALIGN_CENTER);
            table.getDefaultCell().setVerticalAlignment(Element.ALIGN_CENTER);
            table.addCell("Id");
            table.addCell("Vezeteknev");
            table.addCell("Keresztnev");
            table.addCell("email");
            table.setHeaderRows(1);
            
            for(int i=1; i<=data.size(); i++){
                Person actualPerson= data.get(i-1);
                table.addCell(""+i);
                table.addCell(actualPerson.getLastName());
                table.addCell(actualPerson.getFirstName());
                table.addCell(actualPerson.getEmail());
            
            }
            
            table.getDefaultCell().setBackgroundColor(GrayColor.GRAYWHITE );
            table.getDefaultCell().setHorizontalAlignment(Element.ALIGN_CENTER);
            table.getDefaultCell().setVerticalAlignment(Element.ALIGN_CENTER);
            d.add(new Paragraph("\n\n\n\n\n\n\n\n\n\n\n\n\n"));
            d.add(table);
            
            
            
            Chunk signature=new Chunk("\n\n\n"+ "Copyright by Adalbert Barta");
            Paragraph p=new Paragraph(signature);
            d.add(p);
            
        } catch (Exception e) {
            e.printStackTrace() ;
        }
        d.close();
    }

   
    
    
}
