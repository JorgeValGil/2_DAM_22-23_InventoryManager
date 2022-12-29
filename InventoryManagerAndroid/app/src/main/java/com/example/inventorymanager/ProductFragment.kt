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
import com.example.inventorymanager.databinding.FragmentProductBinding

/**
 * A simple [Fragment] subclass as the second destination in the navigation.
 */
class ProductFragment : Fragment() {

    private var _binding: FragmentProductBinding? = null

    private val binding get() = _binding!!

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {

        _binding = FragmentProductBinding.inflate(inflater, container, false)
        return binding.root

    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)


        val id = ProductFragmentArgs.fromBundle(requireArguments()).id
        val name = ProductFragmentArgs.fromBundle(requireArguments()).name
        val image = ProductFragmentArgs.fromBundle(requireArguments()).image
        val description = ProductFragmentArgs.fromBundle(requireArguments()).description
        val categoryName = ProductFragmentArgs.fromBundle(requireArguments()).categoryName
        val reference = ProductFragmentArgs.fromBundle(requireArguments()).reference
        val price = ProductFragmentArgs.fromBundle(requireArguments()).price
        val units = ProductFragmentArgs.fromBundle(requireArguments()).units

        (activity as AppCompatActivity?)!!.supportActionBar!!.setBackgroundDrawable(
            ColorDrawable(
                resources.getColor(R.color.blue_element, binding.root.context.theme)
            )
        )
        (activity as AppCompatActivity?)!!.supportActionBar!!.title = name

        binding.productTvProductName.text = id + " - " + name
        binding.imageView.setImageURI(Uri.parse("android.resource://com.example.inventorymanager/drawable/" + image))
        binding.tvDescripcionProduct.text = description
        binding.tvReferenceProduct.text =
            resources.getString(R.string.reference_product_fragment) + " " + reference
        binding.tvUnitsValue.text = units
        binding.tvPriceValue.text = price
        binding.buttonMoreProducts.text =
            resources.getString(R.string.more_products_category_product_fragment) + " " + categoryName



        binding.buttonMoreProducts.setOnClickListener {
            when (id.toInt()) {
                in 1..3 -> findNavController().navigate(ProductFragmentDirections.actionProductFragmentToProductsComputerFragment())
                in 4..12 -> findNavController().navigate(ProductFragmentDirections.actionProductFragmentToProductsSmartphonesFragment())
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