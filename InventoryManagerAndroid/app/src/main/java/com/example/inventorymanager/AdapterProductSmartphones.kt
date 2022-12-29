package com.example.inventorymanager

import android.net.Uri
import android.view.LayoutInflater
import android.view.ViewGroup
import android.widget.Toast
import androidx.navigation.findNavController
import androidx.recyclerview.widget.RecyclerView
import com.example.inventorymanager.databinding.ElementProductBinding

class AdapterProductSmartphones(private val productList: MutableList<Product>) :
    RecyclerView.Adapter<AdapterProductSmartphones.ViewHolder>() {

    class ViewHolder(binding: ElementProductBinding) : RecyclerView.ViewHolder(binding.root) {
        val element = binding.root
        val name = binding.tvProductName
        val image = binding.imageElementProduct
        val prodId = binding.tvProductId
        val description = binding.tvProductDescription
        val imageName = binding.tvImageProductName
        val categoryName = binding.tvCategoryProductName
        val reference = binding.tvReferenceProduct
        val units = binding.tvUnitsProduct
        val price = binding.tvPriceProduct


        init {
            element.setOnClickListener {
                Toast.makeText(binding.root.context, "${name.text}", Toast.LENGTH_SHORT).show()

                it.findNavController().navigate(
                    ProductsSmartphonesFragmentDirections.actionProductsSmartphonesFragmentToProductFragment(
                        "${name.text}",
                        "${prodId.text}",
                        "${imageName.text}",
                        "${reference.text}",
                        "${description.text}",
                        "${categoryName.text}",
                        "${price.text}",
                        "${units.text}"
                    )
                )

            }
        }

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int) = ViewHolder(
        ElementProductBinding.inflate(
            LayoutInflater.from(parent.context), parent, false
        )
    )

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        holder.name.text = productList[position].name
        holder.prodId.text = productList[position].id.toString()
        holder.image.setImageURI(Uri.parse("android.resource://com.example.inventorymanager/drawable/" + productList[position].image))
        holder.description.text = productList[position].description
        holder.imageName.text = productList[position].image
        holder.categoryName.text = productList[position].categoryName
        holder.reference.text = productList[position].reference
        holder.units.text = productList[position].units.toString()
        holder.price.text = productList[position].price.toString()
    }

    override fun getItemCount(): Int = productList.size

}