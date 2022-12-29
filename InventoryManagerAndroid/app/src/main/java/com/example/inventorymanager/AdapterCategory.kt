package com.example.inventorymanager

import android.net.Uri
import android.view.LayoutInflater
import android.view.ViewGroup
import android.widget.Toast
import androidx.navigation.findNavController
import androidx.recyclerview.widget.RecyclerView
import com.example.inventorymanager.databinding.ElementCategoryBinding

class AdapterCategory(private val categoryList: MutableList<Category>) :
    RecyclerView.Adapter<AdapterCategory.ViewHolder>() {

    class ViewHolder(binding: ElementCategoryBinding) : RecyclerView.ViewHolder(binding.root) {
        val element = binding.root
        val name = binding.tvCategoryName
        val image = binding.imageElementCategory
        val catId = binding.tvCategoryId
        val description = binding.tvCategoryDescription
        val imageName = binding.tvImageCategoryName

        init {
            element.setOnClickListener {
                Toast.makeText(binding.root.context, "${name.text}", Toast.LENGTH_SHORT).show()
                it.findNavController().navigate(
                    CategoriesFragmentDirections.actionCategoriesFragmentToCategoryFragment(
                        "${name.text}", "${catId.text}", "${imageName.text}", "${description.text}"
                    )
                )
            }
        }
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int) = ViewHolder(
        ElementCategoryBinding.inflate(
            LayoutInflater.from(parent.context), parent, false
        )
    )

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        holder.name.text = categoryList[position].name
        holder.catId.text = categoryList[position].id.toString()
        holder.image.setImageURI(Uri.parse("android.resource://com.example.inventorymanager/drawable/" + categoryList[position].image))
        holder.description.text = categoryList[position].description
        holder.imageName.text = categoryList[position].image
    }

    override fun getItemCount(): Int = categoryList.size

}