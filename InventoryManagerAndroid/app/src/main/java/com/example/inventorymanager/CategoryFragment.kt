package com.example.inventorymanager

import android.graphics.drawable.ColorDrawable
import android.net.Uri
import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.navigation.fragment.findNavController
import com.example.inventorymanager.databinding.FragmentCategoryBinding

class CategoryFragment : Fragment() {

    private var _binding: FragmentCategoryBinding? = null

    private val binding get() = _binding!!

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {

        _binding = FragmentCategoryBinding.inflate(inflater, container, false)
        return binding.root

    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)


        val id = CategoryFragmentArgs.fromBundle(requireArguments()).id
        val name = CategoryFragmentArgs.fromBundle(requireArguments()).name
        val image = CategoryFragmentArgs.fromBundle(requireArguments()).image
        val description = CategoryFragmentArgs.fromBundle(requireArguments()).description

        (activity as AppCompatActivity?)!!.supportActionBar!!.setBackgroundDrawable(
            ColorDrawable(
                resources.getColor(R.color.green_element, binding.root.context.theme)
            )
        )
        (activity as AppCompatActivity?)!!.supportActionBar!!.title = name

        binding.tvCategoryName.text = id + " - " + name
        binding.imageView.setImageURI(Uri.parse("android.resource://com.example.inventorymanager/drawable/" + image))
        binding.tvDescription.text = description
        binding.buttonMoreProducts.text =
            resources.getString(R.string.more_products_category_fragment)

        binding.buttonMoreProducts.setOnClickListener {
            when (id.toInt()) {
                1 -> findNavController().navigate(CategoryFragmentDirections.actionCategoryFragmentToProductsComputerFragment())
                2 -> findNavController().navigate(CategoryFragmentDirections.actionCategoryFragmentToProductsSmartphonesFragment())
                else -> {
                    Toast.makeText(
                        binding.root.context,
                        resources.getString(R.string.category_no_products),
                        Toast.LENGTH_SHORT
                    ).show()
                }
            }
        }
    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }
}