<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    $product = new Product();
    $product->name = 'Baúl';
    $product->description = 'Este baúl de color chocolate, hecho a mano con meticulosa artesanía, es un verdadero tesoro. Sus tonos cálidos y su diseño elegante lo convierten en una adición perfecta para tu hogar. Además de ser una hermosa pieza decorativa, este baúl también es funcional y espacioso, lo que te permite almacenar tus pertenencias con estilo. Cada detalle está cuidadosamente trabajado para garantizar la calidad y la durabilidad. Este baúl es una pieza única que refleja la habilidad y la pasión de los artesanos que lo crearon.';
    $product->price = 199.99;
    $product->stock = 10;
    $product->seller_id = 1;
    $product->save();

    $product = new Product();
    $product->name = 'Blusa Artesanal de colores';
    $product->description = 'Nuestra blusa artesanal de colores es una obra maestra de tejido a mano. Cada blusa es única, ya que está tejida con hilos de diferentes tonos, lo que le da un aspecto vibrante y lleno de vida. La artesanía y la atención al detalle son evidentes en cada puntada, lo que la convierte en una prenda que no solo es hermosa, sino también cómoda. Esta blusa no solo refleja la rica tradición artesanal, sino que también es una expresión de la creatividad y la cultura de la región en la que se produce.';
    $product->price = 149.99;
    $product->stock = 100;
    $product->seller_id = 1;
    $product->save();

    $product = new Product();
    $product->name = 'Figura de madera';
    $product->description = 'Esta figura de madera es una verdadera joya tallada a mano por talentosos artesanos locales. Cada detalle ha sido esculpido con amor y cuidado, lo que la convierte en una pieza de arte única y especial. La madera utilizada es de alta calidad y se ha seleccionado minuciosamente para resaltar la belleza natural de la madera. Ya sea como una pieza decorativa en tu hogar o como un regalo significativo, esta figura de madera es una representación tangible de la destreza y la creatividad de los artesanos que la crearon.';
    $product->price = 179.99;
    $product->stock = 30;
    $product->seller_id = 1;
    $product->save();

    $product = new Product();
    $product->name = 'Gato de tela';
    $product->description = 'Nuestro gato de tela es una adorable obra maestra hecha a mano con tejidos típicos de la región. Cada uno de estos gatos es único, con una combinación de colores y patrones que reflejan la rica cultura y tradiciones locales. La artesanía detrás de cada gato es evidente en la atención al detalle y la meticulosa costura. Estos gatos de tela no solo son juguetes encantadores, sino también una expresión de la habilidad y la creatividad de los artesanos que los crearon.';
    $product->price = 49.99;
    $product->stock = 15;
    $product->seller_id = 1;
    $product->save();

    $product = new Product();
    $product->name = 'Ropa interior de tejido para mujer';
    $product->description = 'Nuestra ropa interior de tejido para mujer es una muestra de la tradición textil local y la destreza de las artesanas que la confeccionaron. Cada prenda ha sido tejida con hilos de alta calidad y diseñada para brindar comodidad y elegancia. La atención al detalle es evidente en cada puntada, y la elección de colores y patrones refleja la rica cultura de la región. Al elegir esta ropa interior, estás apoyando a las mujeres artesanas locales y llevando contigo una prenda única y hermosa.';
    $product->price = 99.99;
    $product->stock = 50;
    $product->seller_id = 1;
    $product->save();

    $product = new Product();
    $product->name = 'Licor de Jamaica reposado';
    $product->description = 'Nuestro licor de Jamaica reposado es un deleite para los amantes de las bebidas espirituosas. Cada botella es un testimonio de la artesanía y la tradición que rodea su producción. El licor, con un 20% de alcohol, ha sido cuidadosamente envejecido para obtener su sabor suave y distintivo. Cada sorbo es una experiencia que te transporta a la región de origen, con los sabores y aromas únicos que la caracterizan. Esta botella es mucho más que una bebida; es una celebración de la cultura y la pasión que va en cada gota.';
    $product->price = 499.99;
    $product->stock = 10;
    $product->seller_id = 1;
    $product->save();

    $product = new Product();
    $product->name = 'Mochila de tejido';
    $product->description = 'Nuestra mochila de tejido es una maravilla de colores y diseño. Cada hilo se ha tejido con precisión para crear un patrón atractivo y alegre que la hace destacar. Además de ser visualmente impresionante, esta mochila es práctica y espaciosa, ideal para llevar tus pertenencias de manera cómoda y elegante. Llevar esta mochila es como llevar un trozo de arte contigo, y es un testimonio de la habilidad de los artesanos que la crearon.';
    $product->price = 299.99;
    $product->stock = 10;
    $product->seller_id = 1;
    $product->save();

    $product = new Product();
    $product->name = 'Tazas artesanales';
    $product->description = 'Nuestras tazas artesanales son piezas únicas que reflejan la creatividad y la habilidad de los artesanos locales. Cada taza ha sido cuidadosamente elaborada y decorada a mano, lo que la hace verdaderamente especial. Los variados colores y diseños distintivos le dan un toque de autenticidad y originalidad a tu colección de vajilla. Disfruta de tus bebidas favoritas con estas tazas que cuentan historias de tradición y artesanía.';
    $product->price = 30;
    $product->stock = 100;
    $product->seller_id = 1;
    $product->save();

    $product = new Product();
    $product->name = 'Vestido Artesanal';
    $product->description = 'Nuestro vestido artesanal es una representación auténtica de las culturas originarias de la región. Cada vestido ha sido confeccionado con tejidos típicos y técnicas tradicionales transmitidas de generación en generación. Llevar este vestido es llevar una parte de la historia y la identidad cultural de la región. Además de su belleza visual, el vestido es cómodo y duradero, lo que lo convierte en una prenda que honra las tradiciones locales y celebra la habilidad de las artesanas que lo crearon.';
    $product->price = 599.99;
    $product->stock = 40;
    $product->seller_id = 1;
    $product->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 1;
    $product_category->category_id = 1;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 1;
    $product_category->category_id = 2;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 1;
    $product_category->category_id = 6;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 1;
    $product_category->category_id = 7;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 2;
    $product_category->category_id = 1;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 2;
    $product_category->category_id = 2;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 2;
    $product_category->category_id = 5;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 2;
    $product_category->category_id = 8;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 3;
    $product_category->category_id = 4;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 3;
    $product_category->category_id = 6;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 4;
    $product_category->category_id = 2;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 4;
    $product_category->category_id = 4;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 4;
    $product_category->category_id = 10;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 5;
    $product_category->category_id = 5;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 5;
    $product_category->category_id = 8;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 5;
    $product_category->category_id = 10;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 6;
    $product_category->category_id = 11;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 7;
    $product_category->category_id = 2;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 7;
    $product_category->category_id = 10;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 8;
    $product_category->category_id = 1;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 8;
    $product_category->category_id = 12;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 9;
    $product_category->category_id = 1;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 9;
    $product_category->category_id = 2;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 9;
    $product_category->category_id = 5;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 9;
    $product_category->category_id = 8;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 9;
    $product_category->category_id = 10;
    $product_category->save();

    $product_category = new ProductCategory();
    $product_category->product_id = 9;
    $product_category->category_id = 13;
    $product_category->save();
  }
}
