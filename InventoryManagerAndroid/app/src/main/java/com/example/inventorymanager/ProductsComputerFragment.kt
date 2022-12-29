package com.example.inventorymanager

import android.graphics.drawable.ColorDrawable
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.Fragment
import com.example.inventorymanager.databinding.FragmentProductsBinding

class ProductsComputerFragment : Fragment() {

    private var _binding: FragmentProductsBinding? = null

    private val binding get() = _binding!!

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        _binding = FragmentProductsBinding.inflate(inflater, container, false)
        return binding.root
    }


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        val productComputerList: MutableList<Product> = ArrayList()

        (activity as AppCompatActivity?)!!.supportActionBar!!.setBackgroundDrawable(
            ColorDrawable(
                resources.getColor(R.color.blue_element, binding.root.context.theme)
            )
        )
        (activity as AppCompatActivity?)!!.supportActionBar!!.setTitle(R.string.cat_ordenadores)

        productComputerList.add(
            Product(
                1,
                resources.getString(R.string.prod_lenovo_ideapad_1_name),
                resources.getString(R.string.prod_lenovo_ideapad_1_description),
                resources.getString(R.string.prod_lenovo_ideapad_1_reference),
                "p" + resources.getString(R.string.prod_lenovo_ideapad_1_reference),
                resources.getString(R.string.cat_ordenadores),
                6,
                579.0F
            )
        )

        productComputerList.add(
            Product(
                2,
                resources.getString(R.string.prod_lenovo_ideapad_2_name),
                resources.getString(R.string.prod_lenovo_ideapad_2_description),
                resources.getString(R.string.prod_lenovo_ideapad_2_reference),
                "p" + resources.getString(R.string.prod_lenovo_ideapad_2_reference),
                resources.getString(R.string.cat_ordenadores),
                0,
                349.0F
            )
        )

        productComputerList.add(
            Product(
                3,
                resources.getString(R.string.prod_hp_victus_name),
                resources.getString(R.string.prod_hp_victus_description),
                resources.getString(R.string.prod_hp_victus_reference),
                "p" + resources.getString(R.string.prod_hp_victus_reference),
                resources.getString(R.string.cat_ordenadores),
                10,
                869.0F
            )
        )

        binding.listProducts.apply { adapter = AdapterProductComputer(productComputerList) }

    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }

}