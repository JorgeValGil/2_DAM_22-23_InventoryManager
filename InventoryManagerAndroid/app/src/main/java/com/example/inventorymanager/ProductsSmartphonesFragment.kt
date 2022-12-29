package com.example.inventorymanager

import android.graphics.drawable.ColorDrawable
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.Fragment
import com.example.inventorymanager.databinding.FragmentProductsBinding

class ProductsSmartphonesFragment : Fragment() {

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
        val productSmartphonesList: MutableList<Product> = ArrayList()

        (activity as AppCompatActivity?)!!.supportActionBar!!.setBackgroundDrawable(
            ColorDrawable(
                resources.getColor(R.color.blue_element, binding.root.context.theme)
            )
        )
        (activity as AppCompatActivity?)!!.supportActionBar!!.setTitle(R.string.cat_smartphones)

        productSmartphonesList.add(
            Product(
                4,
                resources.getString(R.string.prod_iphone_13_name),
                resources.getString(R.string.prod_iphone_13_description),
                resources.getString(R.string.prod_iphone_13_reference),
                "p" + resources.getString(R.string.prod_iphone_13_reference),
                resources.getString(R.string.cat_smartphones),
                1,
                959.0F
            )
        )

        productSmartphonesList.add(
            Product(
                5,
                resources.getString(R.string.prod_samsung_m13_name),
                resources.getString(R.string.prod_samsung_m13_description),
                resources.getString(R.string.prod_samsung_m13_reference),
                "p" + resources.getString(R.string.prod_samsung_m13_reference),
                resources.getString(R.string.cat_smartphones),
                5,
                189.0F
            )
        )

        productSmartphonesList.add(
            Product(
                6,
                resources.getString(R.string.prod_realme_gt_master_name),
                resources.getString(R.string.prod_realme_gt_master_description),
                resources.getString(R.string.prod_realme_gt_master_reference),
                "p" + resources.getString(R.string.prod_realme_gt_master_reference),
                resources.getString(R.string.cat_smartphones),
                3,
                380.0F
            )
        )

        productSmartphonesList.add(
            Product(
                7,
                resources.getString(R.string.prod_xiaomi_redmi_10c_name),
                resources.getString(R.string.prod_xiaomi_redmi_10c_description),
                resources.getString(R.string.prod_xiaomi_redmi_10c_reference),
                "p" + resources.getString(R.string.prod_xiaomi_redmi_10c_reference),
                resources.getString(R.string.cat_smartphones),
                1,
                153.0F
            )
        )

        productSmartphonesList.add(
            Product(
                8,
                resources.getString(R.string.prod_realme_narzo_50_name),
                resources.getString(R.string.prod_realme_narzo_50_description),
                resources.getString(R.string.prod_realme_narzo_50_reference),
                "p" + resources.getString(R.string.prod_realme_narzo_50_reference),
                resources.getString(R.string.cat_smartphones),
                8,
                179.0F
            )
        )

        productSmartphonesList.add(
            Product(
                9,
                resources.getString(R.string.prod_realme_8i_name),
                resources.getString(R.string.prod_realme_8i_description),
                resources.getString(R.string.prod_realme_8i_reference),
                "p" + resources.getString(R.string.prod_realme_8i_reference),
                resources.getString(R.string.cat_smartphones),
                0,
                159.0F
            )
        )

        productSmartphonesList.add(
            Product(
                10,
                resources.getString(R.string.prod_xiaomi_redmi_10_2022_name),
                resources.getString(R.string.prod_xiaomi_redmi_10_2022_description),
                resources.getString(R.string.prod_xiaomi_redmi_10_2022_reference),
                "p" + resources.getString(R.string.prod_xiaomi_redmi_10_2022_reference),
                resources.getString(R.string.cat_smartphones),
                6,
                179.0F
            )
        )

        productSmartphonesList.add(
            Product(
                11,
                resources.getString(R.string.prod_iphone_14_pro_max_name),
                resources.getString(R.string.prod_iphone_14_pro_max_description),
                resources.getString(R.string.prod_iphone_14_pro_max_reference),
                "p" + resources.getString(R.string.prod_iphone_14_pro_max_reference),
                resources.getString(R.string.cat_smartphones),
                1,
                2000.0F
            )
        )

        productSmartphonesList.add(
            Product(
                12,
                resources.getString(R.string.prod_samsung_s22_ultra_5g_name),
                resources.getString(R.string.prod_samsung_s22_ultra_5g_description),
                resources.getString(R.string.prod_samsung_s22_ultra_5g_reference),
                "p" + resources.getString(R.string.prod_samsung_s22_ultra_5g_reference),
                resources.getString(R.string.cat_smartphones),
                1,
                1175.0F
            )
        )

        binding.listProducts.apply { adapter = AdapterProductSmartphones(productSmartphonesList) }

    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }

}